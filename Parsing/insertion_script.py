import pandas as pd
import numpy as np
import mysql.connector



a = pd.read_csv('processed_Sample_data.csv')
a = a.fillna('')

print(a.head())

b = np.array(a)

mydb = mysql.connector.connect(
    host = "localhost",
    user = "hostel",
    password = "hostel",
    database = "test_db",
    unix_socket = "/run/mysqld/mysqld.sock"
)
cursor = mydb.cursor()

# Inserting data into the table using a parameterized query
sql = "INSERT INTO registration(roomno,seater,stayfrom,duration,course,regno,firstName,middleName,lastName,gender,contactno,emailid,egycontactno,guardianName,guardianRelation,guardianContactno,corresAddress,corresCIty,corresState,corresPincode,pmntAddress,pmntCity,pmnatetState,pmntPincode,postingDate,updationDate) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);"

print(sql)



for j in b:
    
    for k in range(len(j)):
        if k == 5:
            continue
        
        if not j[k]:
            j[k] = None;
            
    cursor.execute(sql, tuple(j))  # Pass all 26 values

    
mydb.commit()


cursor.close()
mydb.close()

print("Data inserted successfully.")
