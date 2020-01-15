SET client_min_messages=WARNING;

CREATE SEQUENCE IF NOT EXISTS public.material_id_materialu_seq_1;

CREATE TABLE IF NOT EXISTS public.Material (
                ID_Materialu INTEGER NOT NULL DEFAULT nextval('public.material_id_materialu_seq_1'),
                Nazwa VARCHAR UNIQUE NOT NULL,
                CONSTRAINT id_materialu PRIMARY KEY (ID_Materialu)
);


ALTER SEQUENCE public.material_id_materialu_seq_1 OWNED BY public.Material.ID_Materialu;

CREATE SEQUENCE IF NOT EXISTS public.gatunek_id_gatunku_seq;

CREATE TABLE IF NOT EXISTS public.Gatunek (
                ID_Gatunku INTEGER NOT NULL DEFAULT nextval('public.gatunek_id_gatunku_seq'),
                Nazwa VARCHAR UNIQUE NOT NULL,
                CONSTRAINT id_gatunku PRIMARY KEY (ID_Gatunku)
);


ALTER SEQUENCE public.gatunek_id_gatunku_seq OWNED BY public.Gatunek.ID_Gatunku;

CREATE SEQUENCE IF NOT EXISTS public.rodzaj_id_rodzaju_seq;

CREATE TABLE IF NOT EXISTS public.Rodzaj (
                ID_Rodzaju INTEGER NOT NULL DEFAULT nextval('public.rodzaj_id_rodzaju_seq'),
                Nazwa VARCHAR UNIQUE NOT NULL,
                CONSTRAINT id_rodzaju PRIMARY KEY (ID_Rodzaju)
);


ALTER SEQUENCE public.rodzaj_id_rodzaju_seq OWNED BY public.Rodzaj.ID_Rodzaju;

CREATE SEQUENCE IF NOT EXISTS public.status_id_statusu_seq;

CREATE TABLE IF NOT EXISTS public.Status (
                ID_Statusu INTEGER NOT NULL DEFAULT nextval('public.status_id_statusu_seq'),
                Status_Dziela VARCHAR UNIQUE NOT NULL,
                CONSTRAINT id_statusu PRIMARY KEY (ID_Statusu)
);


ALTER SEQUENCE public.status_id_statusu_seq OWNED BY public.Status.ID_Statusu;

CREATE SEQUENCE IF NOT EXISTS public.konserwator_id_konserwatora_seq_1;

CREATE TABLE IF NOT EXISTS public.Konserwator (
                ID_Konserwatora INTEGER NOT NULL DEFAULT nextval('public.konserwator_id_konserwatora_seq_1'),
                Nazwa VARCHAR NOT NULL,
                CONSTRAINT id_konserwatora PRIMARY KEY (ID_Konserwatora)
);


ALTER SEQUENCE public.konserwator_id_konserwatora_seq_1 OWNED BY public.Konserwator.ID_Konserwatora;

CREATE SEQUENCE IF NOT EXISTS public.autor_id_autora_seq;

CREATE TABLE IF NOT EXISTS public.Autor (
                ID_Autora INTEGER NOT NULL DEFAULT nextval('public.autor_id_autora_seq'),
                Nazwa VARCHAR NOT NULL,
                Kraj VARCHAR NOT NULL,
                CONSTRAINT id_autora PRIMARY KEY (ID_Autora)
);


ALTER SEQUENCE public.autor_id_autora_seq OWNED BY public.Autor.ID_Autora;

CREATE SEQUENCE IF NOT EXISTS public.dzielo_id_dziela_seq;

CREATE TABLE IF NOT EXISTS public.Dzielo (
                ID_Dziela INTEGER NOT NULL DEFAULT nextval('public.dzielo_id_dziela_seq'),
                URL_toPic VARCHAR UNIQUE NOT NULL,
                CONSTRAINT id_dziela PRIMARY KEY (ID_Dziela)
);


ALTER SEQUENCE public.dzielo_id_dziela_seq OWNED BY public.Dzielo.ID_Dziela;

CREATE TABLE IF NOT EXISTS public.Dzielo_Autor (
                ID_Dziela INTEGER NOT NULL,
                ID_Autora INTEGER NOT NULL,
                CONSTRAINT dzielo_autor_null PRIMARY KEY (ID_Dziela, ID_Autora)
);


CREATE SEQUENCE IF NOT EXISTS public.dane_publiczne_dziela_id_publicznedo_seq;

CREATE TABLE IF NOT EXISTS public.Dane_Publiczne_Dziela (
                ID_PubliczneDO INTEGER NOT NULL DEFAULT nextval('public.dane_publiczne_dziela_id_publicznedo_seq'),
                ID_Dziela INTEGER NOT NULL,
                Tytul VARCHAR NOT NULL,
                Data_Powstania DATE NOT NULL,
                ID_Gatunku INTEGER NOT NULL,
                ID_Rodzaju INTEGER NOT NULL,
                ID_Statusu INTEGER NOT NULL,
                ID_Materialu INTEGER NOT NULL,
                CONSTRAINT id_publicznedo PRIMARY KEY (ID_PubliczneDO, ID_Dziela)
);


ALTER SEQUENCE public.dane_publiczne_dziela_id_publicznedo_seq OWNED BY public.Dane_Publiczne_Dziela.ID_PubliczneDO;

CREATE SEQUENCE IF NOT EXISTS public.prywatne_dane_obrazu_id_prywatnedo_seq;

CREATE TABLE IF NOT EXISTS public.Prywatne_Dane_Obrazu (
                ID_PrywatneDO INTEGER NOT NULL DEFAULT nextval('public.prywatne_dane_obrazu_id_prywatnedo_seq'),
                ID_Dziela INTEGER UNIQUE NOT NULL,
                Estymowana_Wartosc REAL DEFAULT 0.0 NOT NULL CHECK (Estymowana_Wartosc >= 0.0),
                CONSTRAINT id_prywatne_danych_obrazu PRIMARY KEY (ID_PrywatneDO)
);


ALTER SEQUENCE public.prywatne_dane_obrazu_id_prywatnedo_seq OWNED BY public.Prywatne_Dane_Obrazu.ID_PrywatneDO;

CREATE TABLE IF NOT EXISTS public.Konserwacja (
                ID_Konserwacji SERIAL PRIMARY KEY,
                ID_PrywatneDO INTEGER NOT NULL,
                Data VARCHAR NOT NULL,
                Typ_konserwacji VARCHAR NOT NULL
);

CREATE TABLE IF NOT EXISTS public.Konserwator_Konserwacja (
                ID_Konserwacji INTEGER NOT NULL,
                ID_Konserwatora INTEGER NOT NULL,
                CONSTRAINT konserwator_konserwacja_pk PRIMARY KEY (ID_Konserwacji, ID_Konserwatora)
);

SELECT * FROM public.Dane_Publiczne_Dziela;

ALTER TABLE public.Dane_Publiczne_Dziela DROP CONSTRAINT IF EXISTS material_dane_publiczne_dziela_fk;
ALTER TABLE public.Dane_Publiczne_Dziela ADD CONSTRAINT material_dane_publiczne_dziela_fk
FOREIGN KEY (ID_Materialu)
REFERENCES public.Material (ID_Materialu)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Dane_Publiczne_Dziela DROP CONSTRAINT IF EXISTS gatunek_dane_publiczne_obrazu_fk;
ALTER TABLE public.Dane_Publiczne_Dziela ADD CONSTRAINT gatunek_dane_publiczne_obrazu_fk
FOREIGN KEY (ID_Gatunku)
REFERENCES public.Gatunek (ID_Gatunku)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Dane_Publiczne_Dziela DROP CONSTRAINT IF EXISTS technika_dane_publiczne_obrazu_fk;
ALTER TABLE public.Dane_Publiczne_Dziela ADD CONSTRAINT technika_dane_publiczne_obrazu_fk
FOREIGN KEY (ID_Rodzaju)
REFERENCES public.Rodzaj (ID_Rodzaju)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Dane_Publiczne_Dziela DROP CONSTRAINT IF EXISTS status_dane_publiczne_dziela_fk;
ALTER TABLE public.Dane_Publiczne_Dziela ADD CONSTRAINT status_dane_publiczne_dziela_fk
FOREIGN KEY (ID_Statusu)
REFERENCES public.Status (ID_Statusu)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Konserwacja DROP CONSTRAINT IF EXISTS prywatne_dane_obrazu_konserwacja_fk;
ALTER TABLE public.Konserwacja ADD CONSTRAINT prywatne_dane_obrazu_konserwacja_fk
FOREIGN KEY (ID_PrywatneDO)
REFERENCES public.Prywatne_Dane_Obrazu (ID_PrywatneDO)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

--ALTER TABLE public.Konserwator DROP CONSTRAINT IF EXISTS konserwacja_konserwator_fk;
--ALTER TABLE public.Konserwator ADD CONSTRAINT konserwacja_konserwator_fk
--FOREIGN KEY (ID_Konserwacji)
--REFERENCES public.Konserwacja (ID_Konserwacji)
--ON DELETE CASCADE
--ON UPDATE NO ACTION
--NOT DEFERRABLE;

ALTER TABLE public.Konserwacja DROP CONSTRAINT IF EXISTS prywatne_dane_obrazu_konserwacja_fk;
ALTER TABLE public.Konserwacja ADD CONSTRAINT prywatne_dane_obrazu_konserwacja_fk
FOREIGN KEY (ID_PrywatneDO)
REFERENCES public.Prywatne_Dane_Obrazu (ID_PrywatneDO)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Prywatne_Dane_Obrazu DROP CONSTRAINT IF EXISTS obraz_prywatne_dane_obrazu_fk;
ALTER TABLE public.Prywatne_Dane_Obrazu ADD CONSTRAINT obraz_prywatne_dane_obrazu_fk
FOREIGN KEY (ID_Dziela)
REFERENCES public.Dzielo (ID_Dziela)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Dane_Publiczne_Dziela DROP CONSTRAINT IF EXISTS obraz_dane_publiczne_obrazu_fk;
ALTER TABLE public.Dane_Publiczne_Dziela ADD CONSTRAINT obraz_dane_publiczne_obrazu_fk
FOREIGN KEY (ID_Dziela)
REFERENCES public.Dzielo (ID_Dziela)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Dzielo_Autor DROP CONSTRAINT IF EXISTS dzielo_dzielo_autor_fk;
ALTER TABLE public.Dzielo_Autor ADD CONSTRAINT dzielo_dzielo_autor_fk
FOREIGN KEY (ID_Dziela)
REFERENCES public.Dzielo (ID_Dziela)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Konserwator_Konserwacja DROP CONSTRAINT IF EXISTS konserwacja_konserwator_konserwacja_fk;
ALTER TABLE public.Konserwator_Konserwacja ADD CONSTRAINT konserwacja_konserwator_konserwacja_fk
FOREIGN KEY (ID_Konserwacji)
REFERENCES public.Konserwacja (ID_Konserwacji)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.Konserwator_Konserwacja DROP CONSTRAINT IF EXISTS konserwator_konserwator_konserwacja_fk;
ALTER TABLE public.Konserwator_Konserwacja ADD CONSTRAINT konserwator_konserwator_konserwacja_fk
FOREIGN KEY (ID_Konserwatora)
REFERENCES public.Konserwator (ID_Konserwatora)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-------views:

--All public

CREATE OR REPLACE view publicView AS SELECT D.ID_Dziela, D.URL_toPic, DPD.Tytul, A.Nazwa AS Autor, A.Kraj, G.Nazwa AS Gatunek, R.Nazwa AS Rodzaj, 
M.Nazwa AS Material, DPD.Data_Powstania AS Data_Powstania, S.Status_Dziela AS Status FROM Dzielo D, Dane_Publiczne_Dziela DPD, Autor A, Dzielo_Autor DA,
Gatunek G, Rodzaj R, Material M, Status S WHERE 
D.ID_Dziela = DPD.ID_Dziela AND
D.ID_Dziela = DA.ID_Dziela AND
DA.ID_Autora = A.ID_Autora AND
S.ID_Statusu = DPD.ID_Statusu AND
R.ID_Rodzaju = DPD.ID_Rodzaju AND
M.ID_Materialu = DPD.ID_Materialu AND
G.ID_Gatunku = DPD.ID_Gatunku;

CREATE OR REPLACE view privateView AS SELECT D.ID_Dziela, DPD.Tytul, A.Nazwa AS Autor, A.Kraj, S.Status_Dziela AS Status, PDO.Estymowana_Wartosc, Ka.Data, 
Ka.Typ_konserwacji AS Typ, Kr.Nazwa AS Konserwator FROM Dzielo D, Dane_Publiczne_Dziela DPD, Prywatne_Dane_Obrazu PDO, Autor A, Dzielo_Autor DA,
 Status S, Konserwacja Ka, Konserwator Kr, Konserwator_Konserwacja KK WHERE 
D.ID_Dziela = DPD.ID_Dziela AND
D.ID_Dziela = DA.ID_Dziela AND
DA.ID_Autora = A.ID_Autora AND
S.ID_Statusu = DPD.ID_Statusu AND
PDO.ID_Dziela = D.ID_Dziela AND
PDO.ID_PrywatneDO = Ka.ID_PrywatneDo AND
Ka.ID_Konserwacji = KK.ID_Konserwacji AND
kr.ID_Konserwatora = KK.ID_Konserwatora;

CREATE OR REPLACE view allView AS SELECT * FROM publicView NATURAL FULL OUTER JOIN privateView;




-------triggers:


--Checks if atrwork is not already there
CREATE OR REPLACE function checkForMultiple() RETURNS trigger AS '
    DECLARE
    arg RECORD;
    NEWAutorID integer;
    OTHERAutorID integer;
    BEGIN
    SELECT ID_Autora INTO NEWAutorID FROM Dzielo_Autor WHERE NEW.ID_Dziela = Dzielo_Autor.ID_Dziela;
    FOR arg IN SELECT * FROM Dane_Publiczne_Dziela LOOP
        IF NEW.Tytul = arg.Tytul THEN
            SELECT ID_Autora INTO OTHERAutorID FROM Dzielo_Autor WHERE arg.ID_Dziela = Dzielo_Autor.ID_Dziela;
            IF NEWAutorID = OTHERAutorID THEN
                RAISE EXCEPTION ''Takie dzielo juz jest w katalogu!!!'';
            END IF;
        END IF;
    END LOOP;
    RETURN NEW;
END;
' LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS TR_Dane_Publiczne_Dziela on Dane_Publiczne_Dziela;
CREATE TRIGGER TR_Dane_Publiczne_Dziela before insert on Dane_Publiczne_Dziela for each row execute procedure checkForMultiple();

-------functions

--adds new piece to art catalog with values of Autor.Nazwa and Autor.Kraj

CREATE OR REPLACE function addNewPiece(Dzielo.URL_toPic%TYPE, Autor.Nazwa%TYPE, Autor.Kraj%TYPE) RETURNS integer AS '
    DECLARE
    URLpic ALIAS FOR $1;
    AutorName ALIAS FOR $2;
    AutorKraj ALIAS FOR $3;
    IdDziela integer;
    IdAutora integer;
    CountTmp integer;

    BEGIN
    INSERT INTO Dzielo(URL_toPic) VALUES (URLpic);
    SELECT MAX(ID_Dziela) INTO IdDziela FROM Dzielo;
    SELECT COUNT(ID_Autora) INTO CountTmp FROM Autor where AutorName = Nazwa AND AutorKraj = Kraj;
    
    IF CountTmp = 0 THEN
        INSERT INTO Autor(Nazwa, Kraj) VALUES (AutorName, AutorKraj);
    END IF;
    SELECT ID_Autora INTO IdAutora FROM Autor where AutorName = Nazwa AND AutorKraj = Kraj;
    
    INSERT INTO Dzielo_Autor(ID_Dziela, ID_Autora) VALUES (IdDziela, IdAutora);

    RETURN IdDziela;
END;
' LANGUAGE plpgsql;

--adds new piece to art catalog with values of Autor.ID_Autora

CREATE OR REPLACE function addNewPiece(Dzielo.URL_toPic%TYPE, Autor.Id_Autora%TYPE) RETURNS integer AS '
    DECLARE
    URLpic ALIAS FOR $1;
    AutorID ALIAS FOR $2;
    IdDziela integer;
    CountTmp integer;

    BEGIN
    INSERT INTO Dzielo(URL_toPic) VALUES (URLpic);
    SELECT MAX(ID_Dziela) INTO IdDziela FROM Dzielo;

    INSERT INTO Dzielo_Autor(ID_Dziela, ID_Autora) VALUES (IdDziela, AutorID);

    RETURN IdDziela;
END;
' LANGUAGE plpgsql;


--adds public data to art catalog

CREATE OR REPLACE function addNewArt(Dane_Publiczne_Dziela.ID_Dziela%TYPE, TEXT, TEXT, Dane_Publiczne_Dziela.ID_Gatunku%TYPE, Dane_Publiczne_Dziela.ID_Rodzaju%TYPE, Dane_Publiczne_Dziela.ID_Statusu%TYPE, Dane_Publiczne_Dziela.ID_Materialu%TYPE) RETURNS integer AS '
    DECLARE
    DPDIdDziela ALIAS FOR $1;
    DPDtutul ALIAS FOR $2;
    DPDData ALIAS FOR $3;
    DPDGatunek ALIAS FOR $4;
    DPDRodzaj ALIAS FOR $5;
    DPDStatus ALIAS FOR $6;
    DPDMaterial ALIAS FOR $7;
    CountTmp integer;

    BEGIN
    SELECT COUNT(ID_Dziela) INTO CountTmp FROM Dzielo WHERE DPDIdDziela = ID_Dziela;
    IF CountTmp = 0 THEN
        RAISE EXCEPTION ''Takiego dziela nie ma w katalogu!!!'';
    END IF;
    
    INSERT INTO Dane_Publiczne_Dziela (ID_Dziela, Tytul, Data_Powstania, ID_Gatunku,ID_Rodzaju, ID_Statusu, ID_Materialu)
        VALUES (DPDIdDziela, DPDtutul, TO_DATE(DPDData, ''YYYY/MM/DD''), DPDGatunek, DPDRodzaj, DPDStatus, DPDMaterial);

    INSERT INTO Prywatne_Dane_Obrazu (ID_Dziela) VALUES (DPDIdDziela);

    RETURN DPDIdDziela;
END;
' LANGUAGE plpgsql;

CREATE OR REPLACE function addNewPrivate(Prywatne_Dane_Obrazu.ID_Dziela%TYPE, Prywatne_Dane_Obrazu.estymowana_wartosc%TYPE) RETURNS integer AS '
    DECLARE
    PDOIdDziela ALIAS FOR $1;
    PDOEstWar ALIAS FOR $2;
    CountTmp integer;

    BEGIN

    INSERT INTO Prywatne_Dane_Obrazu(id_dziela, estymowana_wartosc) VALUES (PDOIdDziela, PDOEstWar);
    SELECT id_PrywatneDO INTO CountTmp FROM Prywatne_Dane_Obrazu WHERE id_dziela = PDOIdDziela;
    
    RETURN CountTmp;
END;
' LANGUAGE plpgsql;
