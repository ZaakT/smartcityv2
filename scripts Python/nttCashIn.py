# -*- coding: utf-8 -*-
"""
Created on Mon Oct 26 17:07:23 2020

@author: Diego
"""

import pymysql.cursors  
import pandas


data = pandas.read_csv('D:/wamp64/www/smartcityv2/scripts Python/benefits.csv', sep=';', engine='python', header=None)
    
def insert_uc_cat(name, description):
    
    with connection.cursor() as cursor:
        sql="INSERT INTO `use_case_cat` (`name`,`description`) VALUES (%s,%s);"
        cursor.execute(sql, (name,description))
    connection.commit()

def uploadData(name, ucName, ucID, xpexType, unit, source, unit_cost, vol_red_min, vol_red_max, unit_cost_red_min, unit_cost_red_max):


    with connection.cursor() as cursor:            
        if(xpexType=="UC Revenues (New) " or xpexType=="UC Revenues (New)" ):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_revenues`;')
            cursor.execute(""" CREATE PROCEDURE `add_revenues`(
                                IN revenues_name VARCHAR(255),
                                IN revenues_desc VARCHAR(255),
                                IN idUC INT,
                                IN unit VARCHAR(255),
                                IN source VARCHAR(255),
                                IN range_min INT,
                                IN range_max INT
                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO revenues_item (name,description)
                                        VALUES (revenues_name,revenues_desc);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO revenues_uc (id_item,id_uc)
                                        VALUES (itemID,idUC);
                                    INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max)
                                        VALUES (itemID,unit,source,range_min,range_max);
                                END
                                    """)
            sql = 'CALL add_revenues(%s,%s,%s,%s, %s, %s,%s);'
            toUpload = (ucName, "", ucID, unit, source, 0, 0)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
        elif(xpexType=="cashreleasing"):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_cashreleasing`;')
            cursor.execute("""  CREATE PROCEDURE `add_cashreleasing`(
                                IN cashreleasing_name VARCHAR(255),
                                IN cashreleasing_desc VARCHAR(255),
                                IN unit VARCHAR(255),
                                IN source VARCHAR(255),
                                IN unit_cost INT,
                                IN min_red_nb INT,
                                IN max_red_nb INT,
                                IN min_red_cost INt,
                                IN max_red_cost INT,
                                IN idUC INT
                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO cashreleasing_item (name,description)
                                        VALUES (cashreleasing_name,cashreleasing_desc);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO cashreleasing_uc (id_item,id_uc)
                                        VALUES (itemID,idUC);
                                    INSERT INTO cashreleasing_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                        VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                END
                                    """)
            sql = 'CALL add_cashreleasing(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s);'
            toUpload = (ucName, "", unit, source, unit_cost, vol_red_min, vol_red_max,unit_cost_red_min, unit_cost_red_max, ucID)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
        elif(xpexType=="widercash"):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_widercash`;')
            cursor.execute("""  CREATE PROCEDURE `add_widercash`(
                                IN widercash_name VARCHAR(255),
                                IN widercash_desc VARCHAR(255),
                                IN unit VARCHAR(255),
                                IN source VARCHAR(255),
                                IN unit_cost INT,
                                IN min_red_nb INT,
                                IN max_red_nb INT,
                                IN min_red_cost INt,
                                IN max_red_cost INT,
                                IN idUC INT
                                )
                                BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO widercash_item (name,description)
                                        VALUES (widercash_name,widercash_desc);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO widercash_uc (id_item,id_uc)
                                        VALUES (itemID,idUC);
                                    INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                        VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                END
                                    """)
            sql = 'CALL add_widercash(%s,%s,%s,%s, %s, %s,%s, %s,%s, %s);'
            toUpload = (ucName, "", unit, source, unit_cost, vol_red_min, vol_red_max,unit_cost_red_min, unit_cost_red_max, ucID)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
        elif(xpexType=="Quantifiable, non-monetizable benefits " or xpexType=="Quantifiable, non-monetizable benefits"):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_quantifiable`;')
            cursor.execute("""  CREATE PROCEDURE `add_quantifiable`(
                                    IN quantifiable_name VARCHAR(255),
                                    IN quantifiable_desc VARCHAR(255),
                                    IN unit VARCHAR(255),
                                    IN source VARCHAR(255),
                                    IN min_red_nb INT,
                                    IN max_red_nb INT,
                                    IN idUC INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO quantifiable_item (name,description)
                                            VALUES (quantifiable_name,quantifiable_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO quantifiable_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO quantifiable_item_advice (id,unit,source,range_min_red_nb,range_max_red_nb)
                                            VALUES (itemID,unit,source,min_red_nb,max_red_nb);
                                    END
                            
                                    """)
            sql = 'CALL add_quantifiable(%s,%s,%s,%s,%s,%s,%s);'
            toUpload = (ucName, "",unit, source, vol_red_min, vol_red_max, ucID)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
            
        elif(xpexType=="Non quantifiable  benefits " or xpexType=="Non quantifiable  benefits"):
            cursor.execute('DROP PROCEDURE IF EXISTS `add_noncash`;')
            cursor.execute("""  CREATE PROCEDURE `add_noncash`(
                                    IN noncash_name VARCHAR(255),
                                    IN noncash_desc VARCHAR(255),
                                    IN idUC INT
                                    )
                                    BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO noncash_item (name,description) 
                                                VALUES (noncash_name,noncash_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO noncash_uc (id_item,id_uc) VALUES (itemID,idUC);
                                    END
                                    """)
            sql = 'CALL add_noncash(%s,%s,%s);'
            toUpload = (ucName, "",ucID)
            print(toUpload)
            cursor.execute(sql, toUpload)
            connection.commit()
                
def get_cat_id(name):
    
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case_cat WHERE name = %s;"
        cursor.execute(sql, (name))
        for row in cursor:
            return row['id']

def  getUcIDFromDB(solID, uc):
    with connection.cursor() as cursor:
        sql = "SELECT id FROM use_case WHERE name = %s AND id_cat = %s AND id_meas = %s;"
        cursor.execute(sql, (uc, solID, "25"))
        for row in cursor:
            return row['id']

def getSolUc(data):
    Sol_UC = dict()
    for i in range(data[0].size):
        if( "#" in str(data[1][i])):
            solution = str(data[2][i])
            UC = str(data[3][i])
            if not (solution in Sol_UC.keys()):
                Sol_UC[solution] = []
            if not (UC in Sol_UC[solution]):
                Sol_UC[solution].append(UC)
    return Sol_UC

def getUcID(Sol_UC):
    ucID = dict()
    for solution in Sol_UC:
        solID =  get_cat_id(solution)
        for uc in Sol_UC[solution]: 
            ucID[(solution, uc)] = getUcIDFromDB(solID, uc)
    
    return ucID

if __name__ == "__main__":  
    
        
    connection = pymysql.connect(host='smartcityv2',
                                 user='root',
                                 password='',                             
                                 db='dst_v2_db_updated',
                                 charset='utf8',
                                 cursorclass=pymysql.cursors.DictCursor)

    
    
    
    Sol_UC = getSolUc(data)
    
    ucID_dict = getUcID(Sol_UC) # attention !
    print(ucID_dict)
    for i in range(data[0].size):
        name = None
        if( "#" in str(data[1][i])):
            # print(data[9][i])
            if(str(data[9][i])!="nan"):
                # Il s'agit d'un item non vide
                name = str(data[9][i])
                solution = str(data[2][i])
                ucName= str(data[3][i])
                ucID = ucID_dict[(solution, ucName)] # attention !
                cashInType = str(data[7][i]).split(" - ")
                cashInType = cashInType[len(cashInType)-1]
                unit = str(data[10][i])
                source = ""
                if(str(data[20][i]) != "NA#" and str(data[20][i]) != ""):
                    unit_cost =str(data[20][i])
                elif(str(data[21][i]) != "NA#" and str(data[21][i]) != ""):
                    unit_cost =str(data[21][i])
                else:
                    unit_cost = ""
                
                vol_red_min = str(data[12][i]) if str(data[12][i]) != "NA#" else ""
                vol_red_max = str(data[13][i]) if str(data[13][i]) != "NA#" else ""
                unit_cost_red_min = str(data[14][i]) if str(data[14][i]) != "NA#" else ""
                unit_cost_red_max = str(data[15][i]) if str(data[15][i]) != "NA#" else ""
                # print(i, name, ucName, ucID, cashInType, unit, source, unit_cost, vol_red_min, vol_red_max, unit_cost_red_min, unit_cost_red_max)
                uploadData(name, ucName, ucID, cashInType, unit, source, unit_cost, vol_red_min, vol_red_max, unit_cost_red_min, unit_cost_red_max)
                
            
        
connection.close()