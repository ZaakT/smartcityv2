import pymysql.cursors  
import pandas


data = pandas.read_csv('D:/wamp64/www/smartcityv2/scripts Python/benefits.csv', sep=';', engine='python', header=None)
    
def insert_uc_cat(name, description):
    
    with connection.cursor() as cursor:
        sql="INSERT INTO `use_case_cat` (`name`,`description`) VALUES (%s,%s);"
        cursor.execute(sql, (name,description))
    connection.commit()
    
def insert_uc(name, description, id_meas, id_sol):
    
    with connection.cursor() as cursor:
        sql="""INSERT INTO use_case
                            (name,description,id_meas,id_cat)
                            VALUES (%s, %s, %s, %s);"""
        cursor.execute(sql, (name,description,id_meas, id_sol))
    connection.commit()
    
        
def get_cat_id(name):
    
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case_cat WHERE name = %s;"
        cursor.execute(sql, (name))
        for row in cursor:
            return row['id']

if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)

    
    
    
    
    Sol_UC = dict()
    
    for i in range(data[0].size):
        if( "#" in str(data[1][i])):
            solution = str(data[2][i])
            UC = str(data[3][i])
            if not (solution in Sol_UC.keys()):
                Sol_UC[solution] = []
            if not (UC in Sol_UC[solution]):
                Sol_UC[solution].append(UC)
                    
                    
                    
                    # ('INSERT INTO use_case_cat (name,description) VALUES (?,?)')
                    
    Sol_ID = dict()
    for solution in Sol_UC:
        insert_uc_cat(solution, "")
        Sol_ID[solution] = get_cat_id(solution)
        for uc in Sol_UC[solution]:
            insert_uc(uc, "", 25, Sol_ID[solution])
    # print(Sol_UC)
    # id = get_cat_id("Public Safety")
    print(Sol_ID)

    
        
connection.close()