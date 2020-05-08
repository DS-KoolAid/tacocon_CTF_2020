from selenium import webdriver
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from time import sleep

sleep(20)

driver = webdriver.Remote("http://127.0.0.1:4444/wd/hub", DesiredCapabilities.CHROME)


driver.get("http://comment_server")

cookies = {'name':'admin_id','value':'kCxpAJacgNoGZPEPsgcdAhaVCAXdQyLa6wHUyNPYLhDMYPuEr4inwLmRxsEPqXkK'}


driver.add_cookie(cookies)

driver.get("http://comment_server/view_comments.php")

sleep(5)
html = driver.execute_script("return document.getElementsByTagName('html')[0].innerHTML")
print(html)