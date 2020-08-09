create or replace trigger goldCheck after insert on goldcustomers 
	for each row begin
	update itemorder set shippingfee = 0.0 where :new.custid = itemorder.custid;
	end goldCheck;
/
show errors;
