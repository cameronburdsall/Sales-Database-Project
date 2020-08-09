create or replace procedure addItemOrder (
	orderid in char, id in char, customerid in char, dateOrdered in date,
	num in integer, shippedDate in date default null)
	as
		l_shippingfee decimal (4,2);
		l_gold integer;
		l_comic integer;
		l_copies integer;
	begin
		/*	checking if gold customer	*/
		select count(*) into l_gold from goldCustomers where customerid = goldcustomers.custid;
		if l_gold = 0
		then
			l_shippingfee := 10.00; 
		else
			l_shippingfee := 00.00;
		end if;
		select count(*) into l_comic from comicbooks where id = comicbooks.itemid;
		

		/*	check comic inventory (if comic book)	*/
		if l_comic = 1
		then
			select noofcopies into l_copies from comicbooks where id = comicbooks.itemid;
			if l_copies - num < 0
			then
				dbms_output.put_line('Not enough copies left, please order less');
				return;
			end if;
		end if;
		
		/*	insert values into table	*/
		insert into itemorder
		 values (orderid, 
			customerid, 
			id, 
			dateOrdered, num, shippedDate, l_shippingfee);
		update comicbooks set noofcopies = (noofcopies - num) where comicbooks.itemid = id;
		return;
				
	end;
/
show errors;
