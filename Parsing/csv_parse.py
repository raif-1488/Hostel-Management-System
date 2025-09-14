import csv
import re  

def isValid(s):  
    pattern = re.compile(r"^[6-9][0-9]{9}$")  # Mobile number validation
    return bool(pattern.match(s)) 

with open('/var/www/html/test-hostel-management-system/Sample_data.csv', mode='r', newline='', encoding='utf-8') as infile, \
     open('processed_Sample_data.csv', mode='w', newline='', encoding='utf-8') as outfile:
     
     
    csvReader = csv.reader(infile)
    csvWriter = csv.writer(outfile)
    
    # Read headers
    headers = next(csvReader)  
    csvWriter.writerow(headers)  # Write headers to the new file
    
    first_name_index = headers.index("firstName")
    middle_name_index = headers.index("middleName")
    last_name_index = headers.index("lastName")
    contact_no_index = headers.index("contactno")
    regno_index = headers.index("regno")

    # Process each row
    for line_no, line in enumerate(csvReader, start=2):  # Start at 2 (since row 1 is headers)
        
        
        # **Skip Blank Rows**
        if not any(cell.strip() for cell in line):  # Checks if all cells in a row are empty
            print(f"Skipping blank row at line {line_no}")
            continue  # Skip to the next row
            
            
            
        # **Double Loop to Traverse All Columns**
        for i in range(len(line)):  
            line[i] = line[i].strip()  # Remove extra spaces from all columns
        
        # Process name fields for firstName, middleName, lastName
        firstName = line[first_name_index]
        middleName = line[middle_name_index]
        lastName = line[last_name_index]
        
        if firstName and not middleName and not lastName:
            name_parts = firstName.split()
            
            if len(name_parts) >= 3:
                firstName = name_parts[0]
                lastName = name_parts[-1]
                middleName = " ".join(name_parts[1:-1])
            elif len(name_parts) == 2:
                firstName, lastName = name_parts
                middleName = ""
        
        line[first_name_index] = firstName
        line[middle_name_index] = middleName
        line[last_name_index] = lastName
        
        # Process regNo to remove any extra spaces
        if regno_index is not None:
            line[regno_index] = line[regno_index].replace(" ", "")
            
        
        if regno_index == "":
            line[regno_index] = NULL;
        else:
            line[regno_index] = line[regno_index];

        # Validate contactNo
        contactno = line[contact_no_index]
        if not contactno:
            print(f"Blank Contact_No at line {line_no}") 
        elif not contactno.isdigit():  
            print(f"{contactno} is invalid Contact_No (non-numeric) at line {line_no}")
        elif len(contactno) != 10:
            print(f"{contactno} is invalid Contact_No (wrong length) at line {line_no}")
        elif not isValid(contactno):
            print(f"{contactno} is an invalid mobile number at line {line_no}")
            
        
        

        # Write processed row
        csvWriter.writerow(line)
        


print("Processing complete! Output saved in 'processed_userreg.csv'.")

