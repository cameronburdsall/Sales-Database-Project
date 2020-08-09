/*	inserting comics	*/
insert into storeitems values ('a4452', 9.99);
insert into comicbooks values (
	'2837462093827', 
	'Batman', 
	TO_DATE('12/05/1999', 'MM/DD/YYYY'),
	21,
	'a4452');
insert into storeitems values ('b1472', 14.99);
insert into comicbooks values (
        '7627462091115',
        'Spiderman',
        TO_DATE('08/07/2004', 'MM/DD/YYYY'),
        15,
        'b1472');

/*	inserting tshirts	*/
insert into storeitems values ('yu452', 19.99);
insert into tshirt values ('XL', 'yu452');
insert into storeitems values ('sz412', 14.99);
insert into tshirt values ('S', 'sz412');

/*	inserting customers	*/
insert into customers values ('bb321', 'Jerry','4082233222','jerry@me.com', '1444 Jerry Way')
;
insert into customers values ('ab115', 'Phil','4082244222','phil@me.com', '1492 Phil Ave');
insert into customers values ('byo2t', 'Mike','4066233222','mike@me.com', '123 Mike St')
;
insert into goldcustomers values (TO_DATE('01/01/2020', 'MM/DD/YYYY'), 'byo2t');
