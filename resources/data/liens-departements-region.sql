insert into perimeters_parents (parent_id, child_id)
select 1, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 2, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 5, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 7, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 9, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 10, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 31, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 14, p.id from perimeters p where p.type = "Département";

insert into perimeters_parents (parent_id, child_id)
select 15, p.id from perimeters p where p.id in (16,11,17,18,24,22,21);

insert into perimeters_parents (parent_id, child_id)
select 12, p.id from perimeters p where p.id in (17,18,21);

insert into perimeters_parents (parent_id, child_id)
select p.id, 1 from perimeters p where p.id in (2,5,7,9,10,11,14,15,16,17,18,19,20,11,22,23,24,25,26,31);