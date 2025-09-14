import csv
import re  

with open('/var/www/html/test-hostel-management-system/late_entry.csv', mode='r', newline='', encoding='utf-8') as infile, \
     open('processed_late_entry.csv', mode='w', newline='', encoding='utf-8') as outfile:
     
     
    csvReader = csv.reader(infile)
    csvWriter = csv.writer(outfile)
    
    # Read headers
    headers = next(csvReader)  
    csvWriter.writerow(headers)  # Write headers to the new file
    
    name_index = headers.index("name")
    
    regno_index = headers.index("Student_ID")

    # Process each row
    for line_no, line in enumerate(csvReader, start=2):  # Start at 2 (since row 1 is headers)
        
        
        # **Skip Blank Rows**
        if not any(cell.strip() for cell in line):  # Checks if all cells in a row are empty
            print(f"Skipping blank row at line {line_no}")
            continue  # Skip to the next row
            
            
            
        # **Double Loop to Traverse All Columns**
        for i in range(len(line)):  
            line[i] = line[i].strip()  # Remove extra spaces from all columns
        
        
        
        # Process regNo to remove any extra spaces
        if regno_index is not None:
            line[regno_index] = line[regno_index].replace(" ", "")
            
        
        if regno_index == "":
            line[regno_index] = NULL;
        else:
            line[regno_index] = line[regno_index];
        

        # Write processed row
        csvWriter.writerow(line)
        


print("Processing complete! Output saved in 'processed_late_entry.csv'.")

