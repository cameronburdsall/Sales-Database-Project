create or replace function computeTotal (p_orderid in char)
	return number 
	is 
		l_total decimal(7,2) := 0.0;
		l_itemid char(5);
		l_numitems integer;
		l_shipping decimal (4,2);
		l_custid char(5);
	begin
		select custid into l_custid from itemorder where p.orderid = itemorder.orderid;
		select itemid into l_itemid from itemorder where p_orderid = itemorder.orderid;
		select price into l_total from storeitems where l_itemid = storeitems.itemid;
				
		select noofitems into l_numitems from itemorder where p_orderid = itemorder.orderid;
		select shippingFee into l_shipping from itemorder where p_orderid = itemorder.orderid;
		/*multiply by order size*/
		l_total := l_total * l_numitems;
		/*add shipping costs*/
		l_total := l_total + l_shipping;
		/*7.25% sales tax*/
		l_total := l_total + l_total * 0.0725;
		/*dbms_output.put_line('tot ' || l_total);*/
		if l_total > 100 and (select count(*) from goldcustomers where l_custid = goldcustomers.custid) then
			l_total = l_total - 0.1 * l_total;
		end if;
			
		return l_total;
	end;
/
show errors;

