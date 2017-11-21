DELETE FROM bill_price bp WHERE bp.bill_no=5 

INSERT INTO bill_price(bill_no,product_id, barcode, product_no, product_description, price)
SELECT  m.id bill_id,pp.product_id, pp.barcode, pd.product_no, pd.product_description, pp.price
FROM bill_master m
INNER JOIN bill_detail bd ON m.id = bd.bill_id
INNER JOIN product_price pp ON bd.product_id = pp.product_id
INNER JOIN product_detail pd ON pp.product_id = pd.id AND m.customer_id = pp.customer_id
WHERE m.id=5