import MySQLdb
import serial

ser = serial.Serial('/dev/ttyUSB0', 9600)

while:
    read_serial = ser.readline()
    print "Vazao ", read_serial

    if (read_serial.find("0.00") == -1):

        read_serial = read_serial.replace("\n", "")
        db = MySQLdb.connect("localhost", "root", "senha", "instancia_db")

        cursor = db.cursor()

        sql = "INSERT INTO tbvazao (vazao) VALUES ('%s')" % \
              (read_serial)

        try:

            cursor.execute(sql)

            db.commit()
            print "Salvo"

        except:

            db.rollback()
            print "Nao Salvo"

        db.close()
