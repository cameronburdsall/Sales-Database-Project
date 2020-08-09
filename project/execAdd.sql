exec addItemOrder (
	'ab123',
	'a4452',
	'byot2',
	TO_DATE('08/07/2004', 'MM/DD/YYYY'),
	22
);

exec addItemOrder ('ab133','a4452','bb321',TO_DATE('08/07/2004', 'MM/DD/YYYY'),5);



select count(*) from comicbooks where 'a4452' = comicbooks.itemid;

select noofcopies from comicbooks where 'a4452' = comicbooks.itemid;

