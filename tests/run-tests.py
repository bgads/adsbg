import unittest
import urllib

class MainTests (unittest.TestCase):
    def setUp (self):
        resources = "http://localhost:3000/tests/resources/"
        self.static_url = urllib.urlopen (resources+"static.html")
        self.simple_php_url = urllib.urlopen (resources+"simple.php")
        self.sqlite_php_url = urllib.urlopen (resources+"sqlite.php")

    def test_mimetype (self):
        self.assertEqual (self.static_url.headers.type, 'text/html')

    def test_static_content (self):
        content = self.static_url.read ()
        pos = content.find ("Seems like your server can serve")
        self.assertEqual (pos > 0, True)

    def test_simple_php (self):
        content = self.simple_php_url.read ()
        pos = content.find ("Seems like your server can serve")
        self.assertEqual (pos > 0, True)

    def test_sqlite_php (self):
        content = self.sqlite_php_url.read ()
        pos = content.find ("finished successfully")
        self.assertEqual (pos > 0, True)

if __name__ == '__main__':
    unittest.main()
