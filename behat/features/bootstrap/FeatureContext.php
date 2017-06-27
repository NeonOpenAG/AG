<?php

use Behat\Behat\Exception\PendingException;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I click the :arg1 element
     */
    public function iClickTheElement($selector)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css', $selector);

        if (empty($element)) {
            throw new Exception("No html element found for the selector ('$selector')");
        }

        $element->click();
    }

    /**
     * @When I should see an element :arg1
     */
    public function iShouldSeeAnElement($selector)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css', $selector);

        if (empty($element)) {
            throw new Exception("No html element found for the selector ('$selector')");
        }
    }

	/**
	 * @When I wait :arg1 seconds
	 */
	public function iWaitSeconds($arg1)
	{
		sleep($arg1);
	}

    /**
     * @Then I check the result file exists
     */
    public function iCheckTheResultFileExists()
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css', '.copy-span');
        $url = $element->getText();
        if (!$url) {
            throw new PendingException('Error locating download location');
        }
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', $path);
        $hash = array_pop($parts);

        $home = getenv("HOME");
        $output_path = $home . '/.openag/data/cove/media/' . $hash . '/';
        $output_file = $output_path . 'tiny_iati_good.xml';
        if (!file_exists($output_file)) {
            throw new PendingException('Output file not found: ' . $output_file);
        }
    }

    /**
     * @Then I diff that against the original
     */
    public function iDiffThatAgainstTheOriginal()
    {
        throw new PendingException();
    }
}
