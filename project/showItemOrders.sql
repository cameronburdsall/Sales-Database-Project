create or replace procedure showItemOrders (
	p_custid in char,
	p_date in date
)
	as
		l_name varchar(15);
		l_phone char(10);
		l_email varchar(20);
		l_address varchar(40);
		l_total decimal (7,2);
		l_counter decimal(7,2) := 0.0;
		cursor c1  is select orderid, custid, itemid, dateoforder, noofitems, shippeddate, shippingfee from itemorder where custid = p_custid;
	begin		
		/* get customer info */
		select name into l_name from customers where  custid = p_custid;
		select phone into l_phone from customers where  custid = p_custid;
		select email into l_email from customers where  custid = p_custid;
		select address into l_address from customers where  custid = p_custid;	
		dbms_output.put_line('CUSTOMER: ' || l_name || ' PHONE: ' || l_phone ||
			' EMAIL: ' || l_email || ' ADDRESS: ' || l_address);
		
		for i in c1
		loop
			select computeTotal(i.orderid) into l_total from itemorder where i.orderid = itemorder.orderid;
			dbms_output.put_line('ORDER ID: ' || i.orderid || ' ITEM ID: ' ||
				i.itemid || ' DATE ORDERED: ' || i.dateofOrder || 
				' # of ITEMS: ' || i.noofitems || 'SHIPPED' || 
				i.shippeddate || ' FEES: ' || i.shippingFee || 
				' TOTAL: ' || l_total);
			l_counter := l_counter + l_total;
		end loop;
		dbms_output.put_line('TOTAL SPENT: ' || l_counter);
	end;
/
show errors;
