create or replace procedure setShippingDate (
	p_orderid in char,
	p_shipDate in date
)
	as
		l_date date;
	begin
		select dateoforder into l_date from itemorder where p_orderid = itemorder.orderid;
		if p_shipDate < l_date then
			dbms_output.put_line('Invalid Shipping Date');
			return;
		end if;
		update itemorder set shippedDate = p_shipDate where p_orderid = itemorder.orderid;
		return;
	end;
/
show errors;

