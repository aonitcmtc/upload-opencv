from flask import Flask, render_template,request,redirect,url_for
import pymysql
#import time
import os


app = Flask(__name__,template_folder='template') #
#conn = pymysql.connect(db='person_data', user='root', passwd='605232060', host='localhost', port=3306)
conn = pymysql.connect(host='localhost',user='root',password='605232060',database='person_data' ,port=3306)

@app.route('/')
def home():
    with conn.cursor() as cursor:
        cursor = conn.cursor()
        cursor.execute("SELECT * FROM `person`")
        row = cursor.fetchall()
        return render_template('index.html', datas=row)

#Refresh Function ********>>>
@app.route('/refresh')
def refresh():
        return redirect(url_for('home'))

#Update Function ********>>>
@app.route('/update',methods=['POST'])
def update():
    if request.method == "POST":
        id_update = request.form['No']
        date = request.form['date']
        time = request.form['time']
        person = request.form['person']
        view = request.form['view']
        with conn.cursor() as cursor:
            sql = "UPDATE `person` SET `date`=%s, `time`=%s, `person`=%s, `view`=%s WHERE `person`.`No` = %s"
            #data = (date,time,person,view)
            cursor.execute(sql, (date,time,person,view,id_update))
            #cursor.execute(sql,data)
            cursor.close()
        conn.commit()
        return redirect(url_for('home'))


#Add Function ********>>>
@app.route('/from')
def addfrom():
    return render_template('add.html')

#Delete Function ********>>>
@app.route('/delete/<string:id_data>',methods=['GET'])
def delete(id_data):
    with conn.cursor() as cursor:
        cursor = conn.cursor()
        cursor.execute("DELETE FROM `person` WHERE `person`.`No` = %s",(id_data))
    conn.commit()
    return redirect(url_for('home'))

#Insert Function ********>>>
@app.route('/insert',methods=['POST'])
def insert():
    if request.method == "POST":
        date = request.form['date']
        time = request.form['time']
        person = request.form['person']
        view = request.form['view']
        with conn.cursor() as cursor:
            sql = "INSERT INTO `person`(`date`, `time`, `person`, `view`) VALUES (%s, %s, %s, %s)"
            data = (date,time,person,view)
            #cursor.execute(sql, (date,time,person,view))
            cursor.execute(sql,data)
            cursor.close()
        conn.commit()
        return redirect(url_for('home'))


if __name__ == '__main__':
    port = int(os.getenv('PORT', 8080))
    print("Starting app on port %d" % port)
    #app.run(debug=True, port=port, host='0.0.0.0', threaded=True)
    app.run(debug=True, port=port)
