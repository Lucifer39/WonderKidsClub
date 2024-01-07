import csv

# Specify the input CSV file name and output CSV file name
input_file = 'result_idiom.csv'
output_file = 'result_idiom_proper.csv'

# Open the input CSV file for reading and the output CSV file for writing
with open(input_file, 'r') as csv_in, open(output_file, 'w', newline='') as csv_out:
    reader = csv.reader(csv_in)
    writer = csv.writer(csv_out, quoting=csv.QUOTE_ALL)

    # Iterate through each row in the input CSV file
    for row in reader:
        # Enclose each data value with double quotes and write to output CSV file
        writer.writerow(['"' + str(value) + '"' for value in row])
