import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

public class EbaySearch {

    public static void main(String[] args) {
        // Set the path of the ChromeDriver
        System.setProperty("webdriver.chrome.driver", "resources//webdriver//chromedriver.exe");

        // Create a new instance of the ChromeDriver
        WebDriver driver = new ChromeDriver();

        // Navigate to eBay's search page
        driver.get("https://www.ebay.com/sch/i.html");

        // Find the search field element and enter the product to search for
        WebElement searchField = driver.findElement(By.id("gh-ac"));
        searchField.sendKeys("iphone 11");

        // Find the search button element and click it
        WebElement searchButton = driver.findElement(By.id("gh-btn"));
        searchButton.click();

        // Wait for the search results to load
        try {
            Thread.sleep(5000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        // Print the search results
        WebElement searchResults = driver.findElement(By.id("srp-river-results"));
        System.out.println(searchResults.getText());

        // Close the driver
        driver.quit();
    }
}

 