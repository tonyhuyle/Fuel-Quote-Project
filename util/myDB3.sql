--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

-- Started on 2024-04-12 14:04:35

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4879 (class 1262 OID 5)
-- Name: postgres; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE postgres WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';


ALTER DATABASE postgres OWNER TO postgres;

\connect postgres

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4880 (class 0 OID 0)
-- Dependencies: 4879
-- Name: DATABASE postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- TOC entry 2 (class 3079 OID 16384)
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- TOC entry 4881 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


--
-- TOC entry 3 (class 3079 OID 24622)
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- TOC entry 4882 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


--
-- TOC entry 231 (class 1255 OID 24669)
-- Name: create_profile_after_user_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.create_profile_after_user_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
   INSERT INTO profiles(userid) VALUES (NEW.userid);
   RETURN NEW;
END;
$$;


ALTER FUNCTION public.create_profile_after_user_insert() OWNER TO postgres;

--
-- TOC entry 230 (class 1255 OID 24633)
-- Name: update_is_complete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_is_complete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF NEW.FullName IS NOT NULL AND NEW.Address1 IS NOT NULL AND NEW.City IS NOT NULL AND NEW.UserState IS NOT NULL AND NEW.ZipCode IS NOT NULL THEN
        NEW.IsComplete := TRUE;
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_is_complete() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 24634)
-- Name: fuelquotehistory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fuelquotehistory (
    quoteid uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    userid uuid,
    gallonsrequested numeric(10,2),
    deliveryaddress character varying(255),
    requestdate date,
    deliverydate date,
    suggestedprice numeric(10,2),
    totalamountdue numeric(10,2),
    CONSTRAINT chk_gallonsrequested CHECK ((gallonsrequested > (0)::numeric))
);


ALTER TABLE public.fuelquotehistory OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 24639)
-- Name: profiles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.profiles (
    profileid uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    userid uuid,
    fullname character varying(50),
    address1 character varying(100),
    address2 character varying(100),
    city character varying(100),
    userstate character varying(2),
    zipcode character varying(9),
    iscomplete boolean DEFAULT false
);


ALTER TABLE public.profiles OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 24644)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    userid uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    username character varying(50) NOT NULL,
    passwordhash character varying(255) NOT NULL,
    email character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 4871 (class 0 OID 24634)
-- Dependencies: 217
-- Data for Name: fuelquotehistory; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.fuelquotehistory VALUES ('277bf404-04f2-4a20-8abe-8591cf43cb0e', '727ddc29-248e-4c17-9382-a3729dd5b73a', 14.00, '213 Test Address', '2024-04-12', '2024-05-25', 3.02, 42.28);
INSERT INTO public.fuelquotehistory VALUES ('3cecba2d-4d77-4e89-af0f-a3e6ea02ab3d', '00b08190-0d64-4b68-b290-61f7039201f8', 20.00, '456 Royal Avenue', '2024-04-12', '2024-06-22', 3.02, 60.40);


--
-- TOC entry 4872 (class 0 OID 24639)
-- Dependencies: 218
-- Data for Name: profiles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.profiles VALUES ('88ec9e15-35cf-4283-8312-fb95d3cedaba', '727ddc29-248e-4c17-9382-a3729dd5b73a', 'Micheal Jackson', '123 Hollywood Lane', '', 'Houston', 'GA', '55602', true);
INSERT INTO public.profiles VALUES ('c29db05c-6bb9-4f87-ad6b-97317f0e2af2', '00b08190-0d64-4b68-b290-61f7039201f8', 'Michael Jameson', '223 Test Address ', '', 'Houston', 'MD', '55312', true);


--
-- TOC entry 4873 (class 0 OID 24644)
-- Dependencies: 219
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES ('727ddc29-248e-4c17-9382-a3729dd5b73a', 'Jackson5', '$2y$10$/xzC2zJuEvSujWDEYVTTmuJom1JZzQz2PAkQDhyAHpGIs6wKIbHpe', 'MJ@gmail.com');
INSERT INTO public.users VALUES ('00b08190-0d64-4b68-b290-61f7039201f8', 'Jackson6', '$2y$10$BHBXPQfEhrrtaCXrK3IYUO8vFSSpEmMN7/x6TDPC7PrveuCy7B/UK', 'BMJ@gmail.com');


--
-- TOC entry 4715 (class 2606 OID 24651)
-- Name: fuelquotehistory fuelquotehistory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fuelquotehistory
    ADD CONSTRAINT fuelquotehistory_pkey PRIMARY KEY (quoteid);


--
-- TOC entry 4717 (class 2606 OID 24653)
-- Name: profiles profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_pkey PRIMARY KEY (profileid);


--
-- TOC entry 4719 (class 2606 OID 24655)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 4721 (class 2606 OID 24657)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (userid);


--
-- TOC entry 4723 (class 2606 OID 24672)
-- Name: users users_username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_unique UNIQUE (username);


--
-- TOC entry 4727 (class 2620 OID 24670)
-- Name: users after_user_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER after_user_insert AFTER INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.create_profile_after_user_insert();


--
-- TOC entry 4726 (class 2620 OID 24658)
-- Name: profiles profiles_before_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER profiles_before_update BEFORE UPDATE ON public.profiles FOR EACH ROW EXECUTE FUNCTION public.update_is_complete();


--
-- TOC entry 4724 (class 2606 OID 24659)
-- Name: fuelquotehistory fuelquotehistory_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fuelquotehistory
    ADD CONSTRAINT fuelquotehistory_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(userid);


--
-- TOC entry 4725 (class 2606 OID 24664)
-- Name: profiles profiles_userid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_userid_fkey FOREIGN KEY (userid) REFERENCES public.users(userid);


-- Completed on 2024-04-12 14:04:35

--
-- PostgreSQL database dump complete
--

