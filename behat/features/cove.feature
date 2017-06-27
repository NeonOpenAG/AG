Feature: CoVE
  In order to access CoVE
  I need to be able to upload a file to the application

@cove
Scenario: Upload a sample XML file
  # Given I am on the homepage
  Given I am on "http://localhost:8008"
  Then I should see "Convert, Validate, Explore IATI Data"
  Then I should see "Upload"
  Then I should see "Upload a file"
  When I attach the file "xml/tiny_iati_good.xml" to "original_file"
  And I click the ".btn-primary" element
  Then I should see an element ".glyphicon-save"
  And I click the ".glyphicon-save" element
  # The JS easing requires this
  And I wait 1 seconds
  Then I should see "Use the following url to share these results"
  Then I check the result file exists
