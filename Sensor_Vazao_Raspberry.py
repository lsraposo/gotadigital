import MySQLdb
import serial

ser = serial.Serial('/dev/ttyUSB0', 9600)

while True:
    read_serial = ser.readline()


    if (read_serial.find("0.00") == -1):

        read_serial = read_serial.replace("\n", "")


        db = MySQLdb.connect("localhost", "root", "123", "gotadigital")


        cursor = db.cursor()



        sql = "INSERT INTO tbvazao (vazao, tbEndereco_idEndereco) VALUES ('%s', '%i')" % \
              (read_serial, 1)

        try:

            cursor.execute(sql)

            db.commit()
            print "Vazao Salva = ", read_serial
        except:

            db.rollback()
            print "Ocorreu um erro"


        db.close()