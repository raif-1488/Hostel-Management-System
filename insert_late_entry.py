import pandas as pd
import numpy as np
import mysql.connector



a = pd.read_csv('processed_late_entry.csv')
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
sql = "INSERT INTO girl_log_records(name,date,medical_emergency,alcoholic_substance,theft_record,late_entry,Student_ID) VALUES( %s, %s, %s, %s, %s, %s, %s);"

print(sql)



for j in b:
    
    for k in range(len(j)):
        #if k == 5:
          #  continue
        
        if not j[k]:
            j[k] = None;
            
    cursor.execute(sql, tuple(j))  # Pass all 26 values

    
mydb.commit()


cursor.close()
mydb.close()

print("Data inserted successfully.")
