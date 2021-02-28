--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: -
--

CREATE PROCEDURAL LANGUAGE plpgsql;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: s_menu; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE s_menu (
    cod_menu integer NOT NULL,
    nombre character varying(30) NOT NULL,
    link character varying NOT NULL,
    hijo boolean NOT NULL,
    padre integer NOT NULL,
    posicion integer NOT NULL
);


--
-- Name: s_menu_cod_menu_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE s_menu_cod_menu_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: s_menu_cod_menu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE s_menu_cod_menu_seq OWNED BY s_menu.cod_menu;


--
-- Name: s_menu_cod_menu_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('s_menu_cod_menu_seq', 4, true);


--
-- Name: s_perfiles; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE s_perfiles (
    cod_perfil integer NOT NULL,
    nombre character varying(50) NOT NULL
);


--
-- Name: s_perfiles_cod_perfil_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE s_perfiles_cod_perfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: s_perfiles_cod_perfil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE s_perfiles_cod_perfil_seq OWNED BY s_perfiles.cod_perfil;


--
-- Name: s_perfiles_cod_perfil_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('s_perfiles_cod_perfil_seq', 1, true);


--
-- Name: s_permisos; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE s_permisos (
    cod_permiso integer NOT NULL,
    cod_perfil integer NOT NULL,
    cod_menu integer NOT NULL,
    opciones character varying(4) NOT NULL
);


--
-- Name: s_permisos_cod_permiso_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE s_permisos_cod_permiso_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: s_permisos_cod_permiso_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE s_permisos_cod_permiso_seq OWNED BY s_permisos.cod_permiso;


--
-- Name: s_permisos_cod_permiso_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('s_permisos_cod_permiso_seq', 4, true);


--
-- Name: s_usuarios; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE s_usuarios (
    cod_usuario integer NOT NULL,
    cod_perfil integer NOT NULL,
    nombre character varying(50) NOT NULL,
    usuario character varying(20) NOT NULL,
    clave character varying(50) NOT NULL,
    email character varying(200)
);


--
-- Name: s_usuarios_cod_usuario_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE s_usuarios_cod_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


--
-- Name: s_usuarios_cod_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE s_usuarios_cod_usuario_seq OWNED BY s_usuarios.cod_usuario;


--
-- Name: s_usuarios_cod_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('s_usuarios_cod_usuario_seq', 1, true);


--
-- Name: cod_menu; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE s_menu ALTER COLUMN cod_menu SET DEFAULT nextval('s_menu_cod_menu_seq'::regclass);


--
-- Name: cod_perfil; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE s_perfiles ALTER COLUMN cod_perfil SET DEFAULT nextval('s_perfiles_cod_perfil_seq'::regclass);


--
-- Name: cod_permiso; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE s_permisos ALTER COLUMN cod_permiso SET DEFAULT nextval('s_permisos_cod_permiso_seq'::regclass);


--
-- Name: cod_usuario; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE s_usuarios ALTER COLUMN cod_usuario SET DEFAULT nextval('s_usuarios_cod_usuario_seq'::regclass);


--
-- Data for Name: s_menu; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO s_menu VALUES (2, 'Perfiles', 'perfiles.php', true, 1, 0);
INSERT INTO s_menu VALUES (4, 'Usuarios', 'usuarios.php', true, 1, 2);
INSERT INTO s_menu VALUES (1, 'Administración', 'smenu1', false, 1000, 0);
INSERT INTO s_menu VALUES (3, 'Permisología', 'permisos.php', true, 1, 1);


--
-- Data for Name: s_perfiles; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO s_perfiles VALUES (1, 'Administrador');


--
-- Data for Name: s_permisos; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO s_permisos VALUES (1, 1, 1, '1111');
INSERT INTO s_permisos VALUES (2, 1, 2, '1111');
INSERT INTO s_permisos VALUES (3, 1, 3, '1111');
INSERT INTO s_permisos VALUES (4, 1, 4, '1111');


--
-- Data for Name: s_usuarios; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO s_usuarios VALUES (1, 1, 'Alex Barrios', 'alex', '99800b85d3383e3a2fb45eb7d0066a4879a9dad0', 'alexbariv@gmail.com');


--
-- Name: perfiles_nombre_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_perfiles
    ADD CONSTRAINT perfiles_nombre_key UNIQUE (nombre);


--
-- Name: perfiles_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_perfiles
    ADD CONSTRAINT perfiles_pkey PRIMARY KEY (cod_perfil);


--
-- Name: permisos_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (cod_permiso);


--
-- Name: pk_menu; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_menu
    ADD CONSTRAINT pk_menu PRIMARY KEY (cod_menu);


--
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (cod_usuario);


--
-- Name: usuarios_usuario_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY s_usuarios
    ADD CONSTRAINT usuarios_usuario_key UNIQUE (usuario);


--
-- Name: permisos_cod_perfil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY s_permisos
    ADD CONSTRAINT permisos_cod_perfil_fkey FOREIGN KEY (cod_perfil) REFERENCES s_perfiles(cod_perfil) ON DELETE CASCADE;


--
-- Name: usuarios_cod_perfil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY s_usuarios
    ADD CONSTRAINT usuarios_cod_perfil_fkey FOREIGN KEY (cod_perfil) REFERENCES s_perfiles(cod_perfil);


--
-- Name: public; Type: ACL; Schema: -; Owner: -
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

