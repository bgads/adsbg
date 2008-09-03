import sqlite3, HTMLgen

db = sqlite3.connect ("test.db")
c = db.cursor ()

list_doc = HTMLgen.SimpleDocument (title="List of posts")

post_list = []
c.execute ("select * from posts")
for row in c:
    id = row[0]
    title = row[2]
    content = row[3]

    post_doc = HTMLgen.SimpleDocument (title=title)
    post_doc.append (HTMLgen.Heading (1, title))
    post_doc.append (HTMLgen.Paragraph (content))
    post_doc_name = "post"+str(id)+".html"
    post_doc.write (post_doc_name)

    post_list.append (HTMLgen.A (post_doc_name, title))

list_doc.append (HTMLgen.BulletList (post_list))
list_doc.write ('list.html')
