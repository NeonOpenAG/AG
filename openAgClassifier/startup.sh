#!/bin/bash

# docker run --name openag_mysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v openag_mysql:/var/lib/mysql -d mysql

mysql -u root -p${MYSQL_ROOT_PASSWORD} -h openag_mysql -e "show tables;" agrovoc_autocode
if [ "$?" != "0" ]; then
    mysql -u root -p${MYSQL_ROOT_PASSWORD} -h openag_mysql -e "CREATE DATABASE IF NOT EXISTS agrovoc_autocode;"
    mysql -u root -p${MYSQL_ROOT_PASSWORD} -h openag_mysql agrovoc_autocode < /opt/autocoder/db/create_hierarchy_table.sql
fi

if grep -qa /opt/autocoder/src/model /proc/mounts; then
    datacount=$(ls /opt/autocoder/src/model/clf_data/| wc -l)
    if [ "0" == "$datacount" ]; then
        echo "Fetching model data, this may trake some time"
        wget -O /opt/autocoder/src/model/clf_data/open_ag_models.zip https://s3.amazonaws.com/fc-public/svm/open_ag_models.zip
        unzip -d /opt/autocoder/src/model/clf_data /opt/autocoder/src/model/clf_data/open_ag_models.zip
    fi
else
    echo "openag-claissifier-data volume not mounted, will not proceed"
    exit 1
fi

cat <<EOF > /opt/autocoder/src/model/base/config.py
"""
# Copyright 2017 Foundation Center. All Rights Reserved.
#
# Licensed under the Foundation Center Public License, Version 1.0 (the “License”);
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://gis.foundationcenter.org/licenses/LICENSE-1.0.html
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an “AS IS” BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
# ==============================================================================
"""
db = {"SERVER": "openag_mysql",
      "UID": "root",
      "PWD": "${MYSQL_ROOT_PASSWORD}",
      "DATABASE": "agrovoc_autocode",
      "PORT": "3306"
      }


high_threshold = {1: 0.53,
                  2: 0.66,
                  3: 0.73,
                  4: 0.45}

low_threshold = {1: 0.47,
                 2: 0.47,
                 3: 0.47,
                 4: 0.45}


EOF
