--
-- File generated with SQLiteStudio v3.3.3 on sex abr 29 15:30:27 2022
--
-- Text encoding used: System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: Dish
DROP TABLE IF EXISTS Dish;

CREATE TABLE Dish (
    Dish_id         INTEGER         PRIMARY KEY AUTOINCREMENT,
    Restaurant_id   INTEGER         REFERENCES Restaurant,
    Category_id     INTEGER         REFERENCES DishCategory (Category_id),
    Dish_name       INTEGER         REFERENCES DishName (Name_ID),
    Price           NUMERIC (10, 2),
    Discount_coupon NUMERIC (10, 2),
    Photo           TEXT
);


-- Table: DishCategory
DROP TABLE IF EXISTS DishCategory;

CREATE TABLE DishCategory (
    Category_id   INTEGER PRIMARY KEY AUTOINCREMENT,
    Category_name VARCHAR UNIQUE
);


-- Table: DishesInCart
DROP TABLE IF EXISTS DishesInCart;

CREATE TABLE DishesInCart (
    Cart_id  NUMERIC REFERENCES ShoppingCart,
    Dish_id  NUMERIC REFERENCES Dish (Dish_id),
    Quantity INTEGER CHECK (Quantity > 0),
    PRIMARY KEY (
        Dish_id,
        Cart_id
    )
);

DROP TABLE IF EXISTS ShoppingCart;

CREATE TABLE ShoppingCart (
    Cart_id         INTEGER         PRIMARY KEY AUTOINCREMENT,
    Restaurant_id   INTEGER         REFERENCES Restaurant,
    User_id         INTEGER         REFERENCES User (User_id),
    Discount_coupon NUMERIC (10, 2),
    Date_time       TIMESTAMP,
    Cart_state      INTEGER         REFERENCES ShoppingState (State_id)
);


-- Table: DishName
DROP TABLE IF EXISTS DishName;

CREATE TABLE DishName (
    Name_ID   INTEGER PRIMARY KEY AUTOINCREMENT,
    Dish_name VARCHAR
);


-- Table: Restaurant
DROP TABLE IF EXISTS Restaurant;

CREATE TABLE Restaurant (
    Restaurant_id  INTEGER UNIQUE
                           PRIMARY KEY AUTOINCREMENT,
    Rest_owner     INTEGER REFERENCES User (User_id),
    Rest_name      VARCHAR,
    Location       INTEGER REFERENCES RestaurantLocation (Location_id),
    Address        VARCHAR,
    [phone number] NUMERIC,
    Picture        varchar(255),
    Category       VARCHAR REFERENCES RestaurantCategory (Category_id) ,
    State          INTEGER
);


-- Table: RestaurantCategory
DROP TABLE IF EXISTS RestaurantCategory;

CREATE TABLE RestaurantCategory (
    Category_id   INTEGER PRIMARY KEY,
    Category_name VARCHAR NOT NULL
                          UNIQUE
);

-- Table: RestaurantLocation
DROP TABLE IF EXISTS RestaurantLocation;

CREATE TABLE RestaurantLocation (
    Location_id   INTEGER PRIMARY KEY,
    Location_name VARCHAR NOT NULL
                          UNIQUE
);


-- Table: ReviewDish
DROP TABLE IF EXISTS ReviewDish;

CREATE TABLE ReviewDish (
    Review_id   INTEGER PRIMARY KEY,
    Dish_id     INTEGER REFERENCES Dish (Dish_id),
    User_id     INTEGER REFERENCES User (User_id),
    Review_text TEXT,
    Rating      INTEGER CHECK (Rating > 1 AND 
                               Rating < 5) 
);


-- Table: ReviewRestaurant
DROP TABLE IF EXISTS ReviewRestaurant;

CREATE TABLE ReviewRestaurant (
    Review_id     INTEGER PRIMARY KEY REFERENCES ShoppingCart (Cart_id),
    Review_text   TEXT,
    Rating        INTEGER CHECK (Rating >= 0 AND 
                                 Rating <= 5)
);


-- Table: ReviewRestaurantAnswer
DROP TABLE IF EXISTS ReviewRestaurantAnswer;

CREATE TABLE ReviewRestaurantAnswer (
    Answer_id       INTEGER REFERENCES ReviewRestaurant (Review_id) 
                     PRIMARY KEY,
    Answer_text TEXT
);


-- Table: ShoppingCart
DROP TABLE IF EXISTS ShoppingCart;

CREATE TABLE ShoppingCart (
    Cart_id         INTEGER         PRIMARY KEY AUTOINCREMENT,
    Restaurant_id   INTEGER         REFERENCES Restaurant,
    User_id         INTEGER         REFERENCES User (User_id),
    Discount_coupon NUMERIC (10, 2),
    Date_time       DATETIME,
    Cart_state      INTEGER         REFERENCES ShoppingState (State_id)
);


-- Table: ShoppingState
DROP TABLE IF EXISTS ShoppingState;

CREATE TABLE ShoppingState (
    State_id   INTEGER PRIMARY KEY AUTOINCREMENT,
    State_name VARCHAR
);


-- Table: User
DROP TABLE IF EXISTS User;

CREATE TABLE User (
    User_id           INTEGER PRIMARY KEY AUTOINCREMENT,
    Username          VARCHAR UNIQUE,
    Password          VARCHAR,
    Email             VARCHAR UNIQUE,
    Address           VARCHAR,
    Phone_number      NUMERIC,
    Birthdate         DATE,
    Picture           varchar(255),
    EmailVerified     TEXT    DEFAULT (false),
    VerificationToken TEXT
);


-- Table: UserFavoriteDishes
DROP TABLE IF EXISTS UserFavoriteDishes;

CREATE TABLE UserFavoriteDishes (
    Dish_id INTEGER REFERENCES Dish (Dish_id),
    User_id INTEGER REFERENCES User (User_id),
    PRIMARY KEY (
        Dish_id ASC,
        User_id ASC
    )
);


-- Table: UserFavoriteRestaurants
DROP TABLE IF EXISTS UserFavoriteRestaurants;

CREATE TABLE UserFavoriteRestaurants (
    Restaurant_id INTEGER REFERENCES Restaurant (Restaurant_id),
    User_id       INTEGER REFERENCES User (User_id),
    PRIMARY KEY (
        Restaurant_id,
        User_id
    )
);

INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('vasco_guedes', '$2y$10$7l.0ucNUz0hxlPTlylo8x.4CjitBso.YWXwasvIDx99TopYrCDkdK', 'vasco@gmail.com', 'Vila Nova de Gaia', 938602815, '2001-11-04', true, '175d001109dc29c4d869967d0a241188bb0aa9122560ad59c2c1a954f5304405');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('aulerio_gomes', '$2y$10$rC.I0nuZsYC8dzi7Aq2Lu.nrzwvOamN4CHyBS4RbqyVO/rHEgwdIe', 'aurelio@gmail.com', 'Canidelo', 987444321, '2000-02-10', true, 'b2f2b5d271ee368a70da54c1a6d2ebe327ed4a7aa938b4adb4ee455e06f38832');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('carlos_gomes', '$2y$10$cds5iof4MP5mZ9vs8TOzjugrBHHAVKGCSeiwZJxagdzJv9j0W6XIW', 'carlos@gmail.com', 'Canidelo', 987444321, '2000-02-10', true, 'b2b06d9c1ea9b0b33a61928ca9e1aedd9b30e284b35bbc0c7273fb26f0e74a48');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('rogerio_gomes', '$2y$10$lJ9C0/P1Jh6mGgid1KrVBORHdSO7MuDa2w24uLd4JtECnl27WFuNK', 'rogerio@gmail.com', 'Canidelo', 987444321, '2000-02-10', true, '14d4932a495a31e53bd5d2b95c98b3a7d9fb6968c405fe33abe0a51345102187');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('fabricio_gomes', '$2y$10$5JnvDwxzHCp..bc0IOtm5ukEMR.4mOrv8kTlh8Jh1pxswY6pvzNUW', 'fabricio@gmail.com', 'Canidelo', 987444322, '2000-02-10', true, 'bf289bcff9500b04fe93aa406d50e964164d8c5b0c3167b0335812e34ae816f1');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('roger_gomes', '$2y$10$yLqjrNexBWWKYoerr8zLeODnS0cvOFQIDicg5w8z7AiEv02FGqbJm', 'roger@gmail.com', 'Canidelo', 987444321, '2000-02-10', true, 'f5adbd414f562e96f98720adf2efb0b44e6a645fcb6f0632a553e4d8de422ac2');
INSERT INTO User (Username, Password, Email, Address, Phone_number, Birthdate, EmailVerified, VerificationToken) values ('luis_gomes', '$2y$10$hI1Gnk7KzdXGt.j4MGp12.wgZb6ibrFK.ld9Aoz8.igYiyuUGuTmm', 'luis@gmail.com', 'Canidelo', 987444320, '2000-02-10', true, '83ba766d851c05ef351d3bd5d074477aef45cee946bd956f9f6d3f20d9ff77c3');
INSERT INTO RestaurantCategory (Category_name) values ('Local food');
INSERT INTO RestaurantCategory (Category_name) values ( 'Mexican');
INSERT INTO RestaurantCategory (Category_name) values ( 'Swedish');
INSERT INTO RestaurantCategory (Category_name) values ( 'Latvian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Italian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Spanish');
INSERT INTO RestaurantCategory (Category_name) values ( 'American');
INSERT INTO RestaurantCategory (Category_name) values ( 'Scottish');
INSERT INTO RestaurantCategory (Category_name) values ( 'British');
INSERT INTO RestaurantCategory (Category_name) values ( 'Thai');
INSERT INTO RestaurantCategory (Category_name) values ( 'Japanese');
INSERT INTO RestaurantCategory (Category_name) values ( 'Chinese');
INSERT INTO RestaurantCategory (Category_name) values ( 'Indian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Canadian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Russian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Jewish');
INSERT INTO RestaurantCategory (Category_name) values ( 'Polish');
INSERT INTO RestaurantCategory (Category_name) values ( 'German');
INSERT INTO RestaurantCategory (Category_name) values ( 'French');
INSERT INTO RestaurantCategory (Category_name) values ( 'Hawaiian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Brazilian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Peruvian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Salvadorian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Cuban');
INSERT INTO RestaurantCategory (Category_name) values ( 'Tibetan');
INSERT INTO RestaurantCategory (Category_name) values ( 'Egyptian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Greek');
INSERT INTO RestaurantCategory (Category_name) values ( 'Belgian ');
INSERT INTO RestaurantCategory (Category_name) values ( 'Irish');
INSERT INTO RestaurantCategory (Category_name) values ( 'Welsh');
INSERT INTO RestaurantCategory (Category_name) values ( 'Mormon');
INSERT INTO RestaurantCategory (Category_name) values ( 'Cajun');
INSERT INTO RestaurantCategory (Category_name) values ( 'Portuguese');
INSERT INTO RestaurantCategory (Category_name) values ( 'Turkish');
INSERT INTO RestaurantCategory (Category_name) values ( 'Haitian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Tahitian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Kenyan');
INSERT INTO RestaurantCategory (Category_name) values ( 'Korean');
INSERT INTO RestaurantCategory (Category_name) values ( 'Algerian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Nigerian');
INSERT INTO RestaurantCategory (Category_name) values ( 'Libyan');


INSERT INTO RestaurantLocation (Location_name) values ('Porto');
INSERT INTO RestaurantLocation (Location_name) values ('Lisboa');
INSERT INTO RestaurantLocation (Location_name) values ('Vila Nova de Gaia');
INSERT INTO RestaurantLocation (Location_name) values ( 'Aveiro');
INSERT INTO RestaurantLocation (Location_name) values ( 'Beja');
INSERT INTO RestaurantLocation (Location_name) values ( 'Braga');
INSERT INTO RestaurantLocation (Location_name) values ( 'Bragança');
INSERT INTO RestaurantLocation (Location_name) values ( 'Castelo Branco');
INSERT INTO RestaurantLocation (Location_name) values ( 'Coimbra');
INSERT INTO RestaurantLocation (Location_name) values ( 'Évora');
INSERT INTO RestaurantLocation (Location_name) values ( 'Faro');
INSERT INTO RestaurantLocation (Location_name) values ( 'Guarda');
INSERT INTO RestaurantLocation (Location_name) values ( 'Leiria');
INSERT INTO RestaurantLocation (Location_name) values ( 'Portalegre');
INSERT INTO RestaurantLocation (Location_name) values ( 'Santarém');
INSERT INTO RestaurantLocation (Location_name) values ( 'Setúbal');
INSERT INTO RestaurantLocation (Location_name) values ( 'Viana do Castelo');
INSERT INTO RestaurantLocation (Location_name) values ( 'Vila Real');
INSERT INTO RestaurantLocation (Location_name) values ( 'Viseu');


INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (1, 'Tasca de Lisboa', 'Rua da fábrica', 3, 938602815, 1, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (1, 'Restaurant Food & Drink', 'Rua da república', 2, 938602816, 2, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Little Italy', 'RUA UM' , 17 , 998071518 , 8, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Olivewood Grill', 'RUA B' , 15 , 951643594 , 7,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Pizzazilla', 'RUA QUATRO' , 18 , 976408091 , 2, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Juan in a Million', 'RUA PRINCIPAL' , 5 , 927868499 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Burrito Belly', 'RUA A' , 1 , 921536556 , 4, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'La Mesa (the table)', 'RUA C' , 9 , 911593394 , 4, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'El Toro (the bull)', 'RUA CINCO' , 8 , 961507431 , 5, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'Mucho (too much)', 'RUA SEIS' , 13 , 915943496 , 6, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'La Taberna (the tavern)', 'RUA D' , 2 , 905507601 ,7, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'La Olla (the pan)', 'RUA SETE' , 3 , 917477269 ,8, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'Delicioso', 'RUA OITO' , 1 , 978174667 , 9,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Sabroso (tasty)', 'RUA E' , 9 , 999390887 ,5, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'French Quarter Cafe', 'RUA F' , 9 , 903684760 ,4, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Le Fromage Bistro', 'RUA NOVE' , 7 , 920500762 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Escargots Brasserie', 'RUA DEZ' , 13 , 943337441 ,1, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Bearnaise', 'RUA G' , 1 , 977129816 , 2,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'French Dip Cafe', 'RUA SAO JOSE' , 7 , 902698974 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Cul de Sac Bistro', 'RUA ONZE' , 4 , 933447052 , 4,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Baguette Cafe', 'RUA H' , 4 , 995448816 , 5,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Crepe Savant', 'RUA SAO PAULO' , 3 , 962270797 , 10,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Dijonaise Restaurant', 'RUA DOZE' , 8 , 938975869 , 11,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Dished Paris', 'RUA TREZE' , 2 , 976490909 , 10,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Divine French Dining', 'RUA SANTO ANTONIO' , 15 , 937540167 , 9,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Catching Fresh Everyday', 'AVENIDA BRASIL' , 3 , 954915989 , 8,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Crabby Dock', 'RUA SAO PEDRO' , 13 , 963952450 , 7,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Clam Chop (fish and steak)', 'RUA QUINZE' , 4 , 916028386 , 6,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'City of Fish', 'RUA SAO JOAO' , 20 , 915322552 , 5,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Crab and Prawn', 'RUA QUATORZE' , 11 , 989208676 , 4,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Prawnscape', 'RUA SAO FRANCISCO' , 8 , 999354497 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Mutton Chops', 'RUA SETE DE SETEMBRO' , 8 , 926426224 , 2,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Central Pork', 'RUA DEZESSEIS' , 11 , 931286549 , 1,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Eatmore Fried Chicken', 'RUA QUINZE DE NOVEMBRO' , 3 , 916378004 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Mad for Chicken', 'RUA TIRADENTES ' , 2 , 926139629 , 6,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Belly and Snout (good for BBQ)', 'RUA DEZESSETE ' , 17 , 916182204 , 9,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'Meat U There', 'RUA VINTE ' , 5 , 966178758 , 10,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (1, 'Meatatarian', 'RUA BAHIA ' , 9 , 953947514 , 12,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Beef Blackout', 'RUA AMAZONAS ' , 19 , 905174040 , 10, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'Beef Storm', 'RUA DEZOITO ' , 12 , 902945642 , 7, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Bob Mutton', 'RUA SAO SEBASTIAO ' , 11 , 928682513 , 9,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Carver’s Cut', 'RUA PARANA ' , 5 , 902400843 , 8,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'Friendly Fire (for grills or BBQ)', 'RUA BELA VISTA ' , 17 , 948980496 ,7, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'MadBeef', 'RUA SANTA LUZIA ' , 5 , 924839357 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'GeekChicken', 'RUA SAO JORGE ' , 13 , 970486759 , 4,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'Iron Bone', 'RUA DEZENOVE ' , 12 , 901642844 ,4, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'One for the Road Hog (BBQ)', 'RUA CASTRO ALVES ' , 11 , 954633468 , 3,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'onFire BBQ', 'RUA DUQUE DE CAXIAS ' , 11 , 971595104 , 2,1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'Pork Digest', 'RUA PROJETADA ' , 7 , 967767908 ,1, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Spice House, Spice Mystery', 'RUA RUI BARBOSA ' , 11 , 979509537 ,1, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Nin Com Soup', 'RUA SANTA CATARINA ' , 3 , 965224291 , 9, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (2, 'Wok this Way', 'RUA MINAS GERAIS ' , 16 , 955995347 , 7, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (3, 'Curry Favor', 'RUA SANTOS DUMONT ' , 10 , 977120349 , 6, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (4, 'Beyond the Eggroll', 'RUA ESPIRITO SANTO ' , 1 , 998579236 , 5, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (5, 'The Sumptuous Banquet', 'RUA VINTE E UM ' , 11 , 985431929 , 4, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (6, 'The Feast of Lu', 'RUA VINTE E DOIS ' , 15 , 960019374 , 3, 1);
INSERT INTO Restaurant (Rest_owner, Rest_name, Address, Location, [phone number], Category, State) values (7, 'The Peanut & the Prawn', 'RUA DA PAZ ' , 6 , 988343320 , 2, 1);

INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 1);
INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 15);
INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 7);
INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 5);
INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 33);
INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (1, 10);


INSERT INTO DishCategory (Category_name) values ('Beverages');
INSERT INTO DishCategory (Category_name) values ('Dishes');
INSERT INTO DishCategory (Category_name) values ('Desserts');
INSERT INTO DishCategory (Category_name) values ( 'Meats' );
INSERT INTO DishCategory (Category_name) values ( 'BBQ' );
INSERT INTO DishCategory (Category_name) values ( 'Pasta' );
INSERT INTO DishCategory (Category_name) values ( 'Rice' );
INSERT INTO DishCategory (Category_name) values ( 'Bread' );
INSERT INTO DishCategory (Category_name) values ( 'Cake' );
INSERT INTO DishCategory (Category_name) values ( 'Pizza' );
INSERT INTO DishCategory (Category_name) values ( 'Pie' );
INSERT INTO DishCategory (Category_name) values ( 'Salad' );
INSERT INTO DishCategory (Category_name) values ( 'Sandwich' );
INSERT INTO DishCategory (Category_name) values ( 'Seafood' );
INSERT INTO DishCategory (Category_name) values ( 'Veganfood' );
INSERT INTO DishCategory (Category_name) values ( 'Stir-Fry' );

INSERT INTO DishName (Dish_name) values ('Fanta');
INSERT INTO DishName (Dish_name) values ('Coca-cola');
INSERT INTO DishName (Dish_name) values ('Francesinha');
INSERT INTO DishName (Dish_name) values ('Bifana');
INSERT INTO DishName (Dish_name) values ('Cachorro');
INSERT INTO DishName (Dish_name) values ('Mousse');
INSERT INTO DishName (Dish_name) values ('Bolo de bolacha');
INSERT INTO DishName (Dish_name) values ( 'Absinto' );
INSERT INTO DishName (Dish_name) values ( 'Cachaça' );
INSERT INTO DishName (Dish_name) values ( 'Gim' );
INSERT INTO DishName (Dish_name) values ( 'Rum' );
INSERT INTO DishName (Dish_name) values ( 'Whisky' );
INSERT INTO DishName (Dish_name) values ( 'Vodka' );
INSERT INTO DishName (Dish_name) values ( 'Cerveja' );
INSERT INTO DishName (Dish_name) values ( 'Vinho Tinto' );
INSERT INTO DishName (Dish_name) values ( 'Vinho Verde' );
INSERT INTO DishName (Dish_name) values ( 'Vinho Branco' );
INSERT INTO DishName (Dish_name) values ( 'Champanhe' );
INSERT INTO DishName (Dish_name) values ( 'Conhaque' );
INSERT INTO DishName (Dish_name) values ( 'Saquê' );
INSERT INTO DishName (Dish_name) values ( 'Tequila' );
INSERT INTO DishName (Dish_name) values ( 'Licor ' );
INSERT INTO DishName (Dish_name) values ( 'Soju' );
INSERT INTO DishName (Dish_name) values ( 'Milk' );
INSERT INTO DishName (Dish_name) values ( 'Bread' );
INSERT INTO DishName (Dish_name) values ( 'Butter' );
INSERT INTO DishName (Dish_name) values ( 'Cheese' );
INSERT INTO DishName (Dish_name) values ( 'Yogurt' );
INSERT INTO DishName (Dish_name) values ( 'Sandwich' );
INSERT INTO DishName (Dish_name) values ( 'Pancake' );
INSERT INTO DishName (Dish_name) values ( 'Pie' );
INSERT INTO DishName (Dish_name) values ( 'Honey' );
INSERT INTO DishName (Dish_name) values ( 'Waffle' );
INSERT INTO DishName (Dish_name) values ( 'Donuts' );
INSERT INTO DishName (Dish_name) values ( 'Salad' );
INSERT INTO DishName (Dish_name) values ( 'Meatball' );
INSERT INTO DishName (Dish_name) values ( 'Grilled chicken' );
INSERT INTO DishName (Dish_name) values ( 'Burger' );
INSERT INTO DishName (Dish_name) values ( 'Tuna' );
INSERT INTO DishName (Dish_name) values ( 'Noodles' );
INSERT INTO DishName (Dish_name) values ( 'Egg' );
INSERT INTO DishName (Dish_name) values ( 'Bacon' );
INSERT INTO DishName (Dish_name) values ( 'Pizza' );
INSERT INTO DishName (Dish_name) values ( 'French Fries' );
INSERT INTO DishName (Dish_name) values ( 'Biryani' );
INSERT INTO DishName (Dish_name) values ( 'Pasta' );
INSERT INTO DishName (Dish_name) values ( 'Smoked salmon' );
INSERT INTO DishName (Dish_name) values ( 'Mayonnaise' );
INSERT INTO DishName (Dish_name) values ( 'Taco' );
INSERT INTO DishName (Dish_name) values ( 'Hotdog' );
INSERT INTO DishName (Dish_name) values ( 'Dosa' );
INSERT INTO DishName (Dish_name) values ( 'Chocolate' );
INSERT INTO DishName (Dish_name) values ( 'Ice cream' );
INSERT INTO DishName (Dish_name) values ( 'Bacalhau' );
INSERT INTO DishName (Dish_name) values ( 'Francesinha' );
INSERT INTO DishName (Dish_name) values ( 'Tripas à Moda do Porto' );
INSERT INTO DishName (Dish_name) values ( 'Polvo a Lagareiro' );
INSERT INTO DishName (Dish_name) values ( 'Caldo verde' );
INSERT INTO DishName (Dish_name) values ( 'Sardinhas assadas' );
INSERT INTO DishName (Dish_name) values ( 'Pastel de Belém' );
INSERT INTO DishName (Dish_name) values ( 'Queijadas de Sintra' );
INSERT INTO DishName (Dish_name) values ( 'Cavacas de Resende' );
INSERT INTO DishName (Dish_name) values ( 'Ovos moles de Aveiro' );
INSERT INTO DishName (Dish_name) values ( 'Arroz de Pato' );
INSERT INTO DishName (Dish_name) values ( 'Cozido à Portuguesa' );
INSERT INTO DishName (Dish_name) values ( 'Queijo da Serra da Estrela' );
INSERT INTO DishName (Dish_name) values ( 'Bifana no pão' );
INSERT INTO DishName (Dish_name) values ( 'Ginjinha' );


INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price, Photo) values (1, 1, 1, 1, "1.png");
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price, Photo) values (1, 1, 2, 1, "2.png");
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (1, 2, 3, 10);
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (1, 2, 4, 3.5);
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (1, 2, 5, 4);
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (1, 3, 6, 2.5);
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (1, 3, 7, 2.5);
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 7 , 24 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 10 , 1 , 5 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 4 , 30 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 6 , 31 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 11 , 6 , 6 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 10 , 14 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 12 , 13 , 21 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 1 , 18 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 5 , 12 , 39 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 10 , 1 , 32 , 14 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 1 , 38 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 13 , 36 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 4 , 35 , 3 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 3 , 10 , 33 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 5 , 6 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 12 , 40 , 26 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 11 , 5 , 17 , 25 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 9 , 18 , 24 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 9 , 13 , 24 , 23 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 11 , 2 , 22 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 9 , 34 , 21 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 7 , 25 , 20 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 3 , 18 , 19 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 3 , 12 , 1 , 17 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 10 , 5 , 16 , 14 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 3 , 3 , 39 , 15 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 5 , 13 , 5 , 25 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 3 , 27 , 30 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 12 , 6 , 18 , 20 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 13 , 8 , 22 , 17 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 9 , 30 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 4 , 22 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 12 , 2 , 4 , 14 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 11 , 7 , 17 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 3 , 30 , 19 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 1 , 27 , 17 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 13 , 25 , 24 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 5 , 5 , 40 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 1 , 28 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 10 , 19 , 21 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 4 , 16 , 26 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 12 , 12 , 35 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 7 , 3 , 25 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 2 , 5 , 27 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 8 , 19 , 29 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 5 , 9 , 8 , 31 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 10 , 2 , 11 , 30 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 9 , 13 , 26 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 9 , 1 , 16 , 25 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 8 , 10 , 24 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 9 , 6 , 13 , 23 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 4 , 20 , 20 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 7 , 13 , 21 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 3 , 22 , 22 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 9 , 37 , 19 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 9 , 17 , 18 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 4 , 11 , 17 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 8 , 9 , 40 , 16 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 13 , 2 , 6 , 15 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 4 , 21 , 14 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 9 , 6 , 20 , 14 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 2 , 6 , 4 , 15 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 5 , 1 , 39 , 16 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 13 , 8 , 18 , 17 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 12 , 36 , 18 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 12 , 33 , 19 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 6 , 27 , 20 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 7 , 13 , 23 , 21 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 12 , 2 , 22 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 3 , 1 , 38 , 23 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 2 , 22 , 24 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 9 , 3 , 4 , 25 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 3 , 28 , 26 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 8 , 33 , 27 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 12 , 2 , 13 , 28 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 4 , 7 , 30 , 29 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 7 , 25 , 35 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 1 , 6 , 8 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 6 , 4 , 3 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 38 , 7 , 24 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 42 , 1 , 5 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 53 , 4 , 30 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 47 , 6 , 31 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 37 , 6 , 6 , 11 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 43 , 10 , 14 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 10 , 13 , 21 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 44 , 1 , 18 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 46 , 12 , 39 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 30 , 1 , 32 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 39 , 1 , 38 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 32 , 13 , 36 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 28 , 4 , 35 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 16 , 10 , 33 , 3 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 40 , 5 , 6 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 42 , 12 , 40 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 51 , 5 , 17 , 11 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 29 , 9 , 18 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 32 , 13 , 24 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 27 , 11 , 2 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 21 , 9 , 34 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 41 , 7 , 25 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 24 , 3 , 18 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 49 , 12 , 1 , 3 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 24 , 5 , 16 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 15 , 3 , 39 , 3 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 20 , 13 , 5 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 15 , 3 , 27 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 46 , 6 , 18 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 35 , 8 , 22 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 31 , 9 , 30 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 51 , 4 , 22 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 46 , 2 , 4 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 47 , 7 , 17 , 11 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 48 , 3 , 30 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 29 , 1 , 27 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 31 , 13 , 25 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 26 , 5 , 40 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 32 , 1 , 28 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 28 , 10 , 19 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 48 , 4 , 16 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 28 , 12 , 35 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 17 , 7 , 3 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 16 , 2 , 5 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 27 , 8 , 19 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 32 , 9 , 8 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 37 , 2 , 11 , 10 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 43 , 9 , 13 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 26 , 1 , 16 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 19 , 8 , 10 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 53 , 6 , 13 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 11 , 4 , 20 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 23 , 7 , 13 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 28 , 3 , 22 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 19 , 9 , 37 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 29 , 9 , 17 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 38 , 4 , 11 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 26 , 9 , 40 , 8 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 11 , 2 , 6 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 20 , 4 , 21 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 32 , 6 , 20 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 39 , 6 , 4 , 2 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 53 , 1 , 39 , 5 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 22 , 8 , 18 , 13 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 24 , 12 , 36 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 48 , 12 , 33 , 6 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 39 , 6 , 27 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 18 , 13 , 23 , 7 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 31 , 12 , 2 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 15 , 1 , 38 , 3 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 19 , 2 , 22 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 45 , 3 , 4 , 9 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 34 , 3 , 28 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 22 , 8 , 33 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 50 , 2 , 13 , 12 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 41 , 7 , 30 , 4 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 46 , 7 , 25 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 37 , 6 , 8 , 1 );
INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values ( 35 , 4 , 3 , 6 );


INSERT INTO ShoppingState (State_name) values ('Received');
INSERT INTO ShoppingState (State_name) values ('Preparing');
INSERT INTO ShoppingState (State_name) values ('Ready');
INSERT INTO ShoppingState (State_name) values ('Delivered');
INSERT INTO ShoppingState (State_name) values ('Canceled');
INSERT INTO ShoppingState (State_name) values ('Open');



INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (1, 1, 1, date());
INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (1, 1, 4, date());
INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (1, 1, 5, date());
INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (1, 1, 2, date());
INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (2, 1, 3, date());
INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state, Date_time) values (2, 1, 6, date());

INSERT INTO ReviewRestaurant (Review_id, Review_text, Rating) values (1, "Really liked it", 4);
/*INSERT INTO ReviewRestaurant (Review_id, Review_text, Rating) values (2, "My favorite restaurant", 5);*/


INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (1, 1, 1);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (1, 4, 2);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (1, 6, 5);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (2, 1, 3);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (2, 2, 1);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (2, 4, 2);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (3, 2, 3);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (3, 3, 2);
INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (3, 7, 1);

INSERT INTO UserFavoriteDishes (Dish_id, User_id) values (1, 1);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
