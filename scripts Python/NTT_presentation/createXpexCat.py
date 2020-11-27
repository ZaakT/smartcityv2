import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/benefitItems.csv', sep=';', engine='python', header=None)


def getSolution(j: int):
    return data[2][j]

def getUC(j: int):
    return data[4][j]

def getXpexType(j : int):
    return data[5][j]

def getInput(j: int):
    return data.loc[j, 6:16]

def getScope():
    scope = dict()
    for j in range(2, 260):
        solution = getSolution(j)
        UC = getUC(j)
        if not (solution in scope):
            scope[solution] = dict()
            scope[solution]["id"] = get_cat_id(solution)
            scope[solution]["set"] = dict()
          
        scope[solution]["set"][UC] = get_uc_id(UC, scope[solution]["id"])
    return scope

def get_uc_id(UC: int, id_sol: int):
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case WHERE name = %s AND id_meas = %s AND id_cat = %s;"
        cursor.execute(sql, (UC, 25, id_sol))
        for row in cursor:
            return row['id']
        
def get_cat_id(name: str):
    
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case_cat WHERE name = %s;"
        cursor.execute(sql, (name))
        for row in cursor:
            return row['id']

def get_uc_id_from_scope(scope :dict, sol_name: str, uc_name: str):
    return scope[sol_name]["set"][uc_name]


def insertXpexCat(uc_id, name, xpex_type, side):
    with connection.cursor() as cursor:

        sql = 'INSERT INTO xpex_cat (name,id_uc, xpex_type, side) VALUES (%s,%s,%s,%s);'
        
        toUpload = (name, uc_id, xpex_type, side)
        print(toUpload)
        cursor.execute(sql, toUpload)
        connection.commit()
    
if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    

    scope = getScope()
    l_NTTAcc_supp = ["deployment_costs", "opex", "deployment_revenues", "operating_revenues"]
    l_inf_supp = ["capex", "equipment_revenues"]
    
    l_no_name_supp = [ ]
        
    l_no_name_cust = ["capex", "opex", "revenues", "revenuesProtection", "cashreleasing", "widercash", "quantifiable", "noncash", "risks", "deployment_costs"]
    for sol_name in scope:
        id_sol = scope[sol_name]["id"]
        test = True
        for uc_name in scope[sol_name]["set"]:
                print(uc_name)
                uc_id = scope[sol_name]["set"][uc_name]
                for xpexType in l_no_name_supp : 
                    insertXpexCat(uc_id, "Category", xpexType, "supplier")
                    
                for xpexType in l_no_name_cust : 
                    insertXpexCat(uc_id, "Category", xpexType, "customer")
                
                
                if(test) :
                    for xpexType in l_NTTAcc_supp : 
                        insertXpexCat(uc_id, "NTT Accelerate SMART", xpexType, "supplier")
                    
                    for xpexType in l_inf_supp : 
                        insertXpexCat(uc_id, "Influenced", xpexType, "supplier")
                    test = False
            
            
            
            
    
        
        
        
    