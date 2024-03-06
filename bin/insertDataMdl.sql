insert into dbmdl.hotel(id, nom, adresse1, adresse2, cp, ville, tel, mail)
values(1, 'ibis Styles Lille Centre Gare Beffroi', '172 Rue Pierre Mauroy','','59000','Lille', '0320300054', 'ibisStylesLilleCentreGare@test.com'), 
(2, 'Ibis Budget Lille Gares Vieux-Lille', '10, Rue De Courtrai','', '59000', 'Lille', '0892683078', 'ibisBudgetLilleCentre@test.com');

insert into dbmdl.categorie_chambre(id, libelle_categorie)
values(1, 'single'),(2, 'double');

insert into dbmdl.proposer(id, hotel_id, categorie_id, tarif_nuite)
values(1, 1, 1, 95),(2, 1, 2, 105),(3, 2, 1, 75),(4, 2, 2, 80);

