create or replace trigger goldshippingcheck after insert or update on goldcustomers
		for each row
		begin
			update itemorder set shippingfee = 0.0
				where goldcustomers.custid = itemorder.custid;
		end;

/
show errors;
