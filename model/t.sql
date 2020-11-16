CREATE PROCEDURE `copy_xpex_user`(
    IN description VARCHAR(255), 
    IN name VARCHAR(255), 
    IN origine VARCHAR(255), 
    IN cat VARCHAR(255), 
    IN side VARCHAR(255), 
    IN unit VARCHAR(255), 
    IN id_proj VARCHAR(255), 
    IN id_uc VARCHAR(255), 
    IN period VARCHAR(255), 
    IN unit_cost VARCHAR(255), 
    IN volume VARCHAR(255) 
    ) 
    BEGIN 
    
    DECLARE itemID INT; 
    INSERT INTO capex_item (description,name,origine,cat,description,id,name,origine,side,unit) 
        VALUES (description,name,origine,cat,description,id,name,origine,side,unit); 
    SET itemID = LAST_INSERT_ID(); 
    INSERT INTO capex_item_user (id,id_proj,id,id_proj)
        VALUES (itemID,id_proj,id,id_proj); 
    INSERT INTO input_capex (id_item,id_proj,id_uc,period,unit_cost,volume,id_item,id_proj,id_uc,period,unit_cost,volume) 
        VALUES (itemID,id_proj,id_uc,period,unit_cost,volume,id_item,id_proj,id_uc,period,unit_cost,volume); 
    INSERT INTO capex_uc (id_item,id_uc,id_item,id_uc) 
        VALUES (itemID,id_uc); 
END 

array(4) { 
    ["capex_item"]=> array(11) { 
        [0]=> string(11) "description" 
        [1]=> string(2) "id" 
        [2]=> string(4) "name" 
        [3]=> string(7) "origine" 
        [4]=> string(3) "cat" 
        [5]=> string(11) "description" 
        [6]=> string(2) "id" 
        [7]=> string(4) "name" 
        [8]=> string(7) "origine" 
        [9]=> string(4) "side" 
        [10]=> string(4) "unit" } 
    ["capex_item_user"]=> array(4) { 
        [0]=> string(2) "id" 
        [1]=> string(7) "id_proj" 
        [2]=> string(2) "id" 
        [3]=> string(7) "id_proj" 
    } ["input_capex"]=> array(12) { [0]=> string(7) "id_item" [1]=> string(7) "id_proj" [2]=> string(5) "id_uc" [3]=> string(6) "period" [4]=> string(9) "unit_cost" [5]=> string(6) "volume" [6]=> string(7) "id_item" [7]=> string(7) "id_proj" [8]=> string(5) "id_uc" [9]=> string(6) "period" [10]=> string(9) "unit_cost" [11]=> string(6) "volume" } ["capex_uc"]=> array(4) { [0]=> string(7) "id_item" [1]=> string(5) "id_uc" [2]=> string(7) "id_item" [3]=> string(5) "id_uc" } }