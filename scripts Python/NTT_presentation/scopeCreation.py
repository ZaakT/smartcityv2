import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)


def getSolution(j):
    return data[2][j]

def getUC(j):
    return data[4][j]

def getScope():
    scope = dict()
    for j in range(2, 260):
        solution = getSolution(j)
        UC = getUC(j)
        if not (solution in scope):
            scope[solution] = set()
        scope[solution].add(UC)
    return scope


    
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
    
    scope = getScope()
    print(scope)
    # Sol_ID = []
    # for solution in scope:
    #     insert_uc_cat(solution, "")
    #     Sol_ID[solution] = get_cat_id(solution)
    #     for uc in scope[solution]:
    #         insert_uc(uc, "", 25, Sol_ID[solution])