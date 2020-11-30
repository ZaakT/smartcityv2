import pymysql.cursors  
import pandas


data = pandas.read_csv('C:/wamp64/www/smartcityv2/scripts Python/NTT_presentation/NTTItems.csv', sep=';', engine='python', header=None)


def getSolution(j: int):
    return data[2][j]

def getName(j: int):
    return data[6][j]

def getXpexType(j :int, cashType: str):
    if(cashType == "Cash-in"):
        return data[8][j]
    return data[7][j]
    

def getInput(j: int, cashType: str):
    if(cashType == "Cash-in"):
        res = data.loc[j, 10:14].to_list()
    else:
        res = [data.loc[j, 9]] + data.loc[j, 11:14].to_list()
    res = [float(num.replace(' ', '').replace(',', '.')) if not num == "NA#" else "NA#"  for num in res]
    return res 
    


def get_xpex_cat_id(uc_id):
    with connection.cursor() as cursor:
        sql = "SELECT id_cat, xpex_type FROM xpex_cat WHERE id_uc = %s;"
        cursor.execute(sql, (uc_id))
        res = dict()
        for row in cursor:
           res[row["xpex_type"]]=row['id_cat']
       
        return res
    
def getUcsInSolution(sol_id):
    with connection.cursor() as cursor:
        sql = "SELECT id, name  FROM use_case WHERE id_cat = %s AND id_meas = %s;"
        cursor.execute(sql, (sol_id, 25))
        res = dict()
        for row in cursor:
           res[row['name']]=row["id"]
        return res



def excel_xpex_type_to_bdd_xpex_type(xpex_type: str):
    return {"Opex":"opex",
            "Recurring":"operating_revenues",
            "Capex":"capex",
            "Equipment":"equipment_revenues",
            "Dep Cash-in":"deployment_revenues",
            "Dep Cash-out":"deployment_costs"
            }[xpexType]
    
def getScope():
    scope = dict()
    for j in range(2, 651):
        solution = getSolution(j)
        sol_id = get_cat_id(solution)
        sub_list_UC = getUcsInSolution(sol_id)
        for UC in sub_list_UC:
            if not (solution in scope):
                scope[solution] = dict()
                scope[solution]["id"] = sol_id
                scope[solution]["set"] = dict()
          
            scope[solution]["set"][UC] = {"id" : sub_list_UC[UC],
                                          "list_xpex_cat_id": get_xpex_cat_id(sub_list_UC[UC])}
        
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


def insertXpexData(xpexType: str, inp: list, uc_id: int, id_cat: int, ucName: str, unit: str):
    with connection.cursor() as cursor:
         if(xpexType == "Cash Releasing Benefits" ):
             pass
         elif(xpexType == "Cash Releasing Benefits" ):
             pass
         elif(xpexType == "UC Revenues (Existing)" ):
             pass
         elif(xpexType == "Non quantifiable benefits" ):
             pass
         elif(xpexType == "Quantifiable, non monetizable benefits" ):
             pass
         elif(xpexType == "UC Revenues (New)" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_revenues`;')
            cursor.execute(""" CREATE PROCEDURE `add_revenues`(
                                    IN revenues_name VARCHAR(255),
                                    IN revenues_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT,
                                    IN cat INT,
                                    IN default_revenue VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO revenues_item (name,description,cat)
                                            VALUES (revenues_name,revenues_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO revenues_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max,default_revenue)
                                            VALUES (itemID,unit,source,range_min,range_max,default_revenue);
                                    END
                                    """)
            sql = 'CALL add_revenues(%s,%s,%s,%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, unit, "", inp[3], inp[4], id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Wider Cash Benefits" ):
             pass
         elif(xpexType == "Opex" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_opex`;')
            cursor.execute(""" CREATE PROCEDURE `add_opex`(
                                    IN opex_name VARCHAR(255),
                                    IN opex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT,
                                    IN cat INT,
                                    IN default_cost VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO opex_item (name,description,cat)
                                            VALUES (opex_name,opex_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO opex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO opex_item_advice (id,unit,source,range_min,range_max, default_cost)
                                            VALUES (itemID,unit,source,range_min,range_max, default_cost);
                                    END
                                    """)
            sql = 'CALL add_opex(%s,%s,%s,%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, unit, "", inp[3], inp[4], id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Recurring" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_supplier_revenue`;')
            cursor.execute("""  CREATE PROCEDURE `add_supplier_revenue`(
                                IN revenue_name VARCHAR(255),
                                IN revenue_desc VARCHAR(255),
                                IN idUC INT,
                                IN type_value VARCHAR(255),
                                IN cat INT,
                                IN default_rev FLOAT

                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO supplier_revenues_item (name,description, type, advice_user,cat,default_rev)
                                        VALUES (revenue_name,revenue_desc, type_value, "advice",cat,default_rev);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO supplier_revenues_uc (id_revenue,id_uc)
                                        VALUES (itemID,idUC);
                                END  """)
            sql = 'CALL add_supplier_revenue(%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, "operating", id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Capex" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_capex`;')
            cursor.execute(""" CREATE PROCEDURE `add_capex`(
                                    IN capex_name VARCHAR(255),
                                    IN capex_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT,
                                    IN cat INT,
                                    IN default_cost VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO capex_item (name,description, cat, unit)
                                            VALUES (capex_name,capex_desc, cat, unit);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO capex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO capex_item_advice (id,unit,source,range_min,range_max, default_cost)
                                            VALUES (itemID,unit,source,range_min,range_max, default_cost);
                                    END
                                    """)
            sql = 'CALL add_capex(%s,%s,%s,%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, unit, "", inp[3], inp[4], id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Equipment" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_supplier_revenue`;')
            cursor.execute("""  CREATE PROCEDURE `add_supplier_revenue`(
                                IN revenue_name VARCHAR(255),
                                IN revenue_desc VARCHAR(255),
                                IN idUC INT,
                                IN type_value VARCHAR(255),
                                IN cat INT,
                                IN default_rev FLOAT

                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO supplier_revenues_item (name,description, type, advice_user,cat,default_rev)
                                        VALUES (revenue_name,revenue_desc, type_value, "advice",cat,default_rev);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO supplier_revenues_uc (id_revenue,id_uc)
                                        VALUES (itemID,idUC);
                                END  """)
            sql = 'CALL add_supplier_revenue(%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, "equipment", id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Dep Cash-in" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_supplier_revenue`;')
            cursor.execute("""  CREATE PROCEDURE `add_supplier_revenue`(
                                IN revenue_name VARCHAR(255),
                                IN revenue_desc VARCHAR(255),
                                IN idUC INT,
                                IN type_value VARCHAR(255),
                                IN cat INT,
                                IN default_rev FLOAT

                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO supplier_revenues_item (name,description, type, advice_user,cat,default_rev)
                                        VALUES (revenue_name,revenue_desc, type_value, "advice",cat,default_rev);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO supplier_revenues_uc (id_revenue,id_uc)
                                        VALUES (itemID,idUC);
                                END  """)
            sql = 'CALL add_supplier_revenue(%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, "deployment", id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         elif(xpexType == "Dep Cash-out" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_implem`;')
            cursor.execute("""  CREATE PROCEDURE `add_implem`(
                                    IN implem_name VARCHAR(255),
                                    IN implem_desc VARCHAR(255),
                                    IN idUC INT,
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN range_min INT,
                                    IN range_max INT,
                                    IN cat INT,
                                    IN default_cost VARCHAR(255)
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO implem_item (name,description,cat)
                                            VALUES (implem_name,implem_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO implem_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO implem_item_advice (id,unit,source,range_min,range_max, default_cost)
                                            VALUES (itemID,unit,source,range_min,range_max, default_cost);
                                    END  """)
            sql = 'CALL add_implem(%s,%s,%s,%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "", uc_id, unit, "", inp[3], inp[4], id_cat, inp[0])
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
         else:
             print(xpexType)
    
    
if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)
    

    scope = getScope()
    
    non = []
    for j in range(2, 651):
        sol_name = getSolution(j)
        if sol_name == "ALL": 
            list_sol = scope.keys()
        else:
            list_sol = [sol_name]
        for sol_name in list_sol:
            if(sol_name in scope):
                for uc_name in scope[sol_name]["set"]:
                    uc_id = scope[sol_name]["set"][uc_name]["id"]
                    ucName = getName(j)
                    for cash_type in ["Cash-in", "Cash-out"]:
                        inp = getInput(j, cash_type)
                        xpexType=getXpexType(j, cash_type)
                        print(xpexType)
                        if(xpexType == "Deployment & set-up"):
                            xpexType = "Dep "+cash_type
                        if(excel_xpex_type_to_bdd_xpex_type(xpexType) in scope[sol_name]["set"][uc_name]["list_xpex_cat_id"]): 
                            id_cat = scope[sol_name]["set"][uc_name]["list_xpex_cat_id"][excel_xpex_type_to_bdd_xpex_type(xpexType)]
                            insertXpexData(xpexType, inp, uc_id, id_cat, ucName, "#")
                # pass
    