#!/bin/bash

# docker run --name agmysql -e MYSQL_ROOT_PASSWORD=PASSWORD -v agmysql:/var/lib/mysql -d mysql

mysql -u root -p${MYSQL_ROOT_PASSWORD} -h agmysql -e "show tables;" agrovoc_autocode
if [ \"$?\" != \"0\" ]; then
    mysql -u root -p${MYSQL_ROOT_PASSWORD} -h agmysql < /var/tmp/install.sql
    cat /opt/autocoder/src/model/base/config.py<<EOF
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
db = {"SERVER": "agmysql",
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
fi

pip install wheel
pip install pandas
python /var/tmp/fetch_corpora.py
cd /opt/autocoder/src/model
python train.py model_h1 0.1 1 3
