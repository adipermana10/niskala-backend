--
-- PostgreSQL database dump
--

\restrict cy0d0EGPh27wxGpbSB5id0I6pf21xCh4EtS3OItqaXKSfORzxjgdbgudfXh2Izx

-- Dumped from database version 18.6
-- Dumped by pg_dump version 18.6

-- Started on 2026-11-06 19:22:35

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 225 (class 1259 OID 17844)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 17855)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 17957)
-- Name: campaigns; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.campaigns (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    disaster_id bigint,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text NOT NULL,
    target_amount numeric(15,2) NOT NULL,
    collected_amount numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    deadline date,
    status character varying(20) DEFAULT 'active'::character varying NOT NULL,
    thumbnail character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.campaigns OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 17956)
-- Name: campaigns_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.campaigns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.campaigns_id_seq OWNER TO postgres;

--
-- TOC entry 5153 (class 0 OID 0)
-- Dependencies: 236
-- Name: campaigns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.campaigns_id_seq OWNED BY public.campaigns.id;


--
-- TOC entry 233 (class 1259 OID 17917)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text,
    icon character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 17916)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5154 (class 0 OID 0)
-- Dependencies: 232
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 235 (class 1259 OID 17931)
-- Name: disasters; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disasters (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    location character varying(255) NOT NULL,
    occurred_at timestamp(0) without time zone NOT NULL,
    status character varying(30) DEFAULT 'tanggap_darurat'::character varying NOT NULL,
    summary text NOT NULL,
    content text NOT NULL,
    thumbnail character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    latitude numeric(10,7) DEFAULT '-7.540717'::numeric NOT NULL,
    longitude numeric(10,7) DEFAULT 110.445724 NOT NULL,
    impact_radius_km numeric(6,2) DEFAULT '5'::numeric NOT NULL
);


ALTER TABLE public.disasters OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 17930)
-- Name: disasters_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.disasters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.disasters_id_seq OWNER TO postgres;

--
-- TOC entry 5155 (class 0 OID 0)
-- Dependencies: 234
-- Name: disasters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.disasters_id_seq OWNED BY public.disasters.id;


--
-- TOC entry 239 (class 1259 OID 17994)
-- Name: donations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.donations (
    id bigint NOT NULL,
    campaign_id bigint NOT NULL,
    user_id bigint,
    invoice_number character varying(255) NOT NULL,
    donor_name character varying(255) NOT NULL,
    donor_email character varying(255),
    is_anonymous boolean DEFAULT false NOT NULL,
    amount numeric(15,2) NOT NULL,
    message text,
    payment_method character varying(50) DEFAULT 'QRIS'::character varying NOT NULL,
    status character varying(20) DEFAULT 'verified'::character varying NOT NULL,
    verified_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.donations OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 17993)
-- Name: donations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.donations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.donations_id_seq OWNER TO postgres;

--
-- TOC entry 5156 (class 0 OID 0)
-- Dependencies: 238
-- Name: donations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.donations_id_seq OWNED BY public.donations.id;


--
-- TOC entry 231 (class 1259 OID 17897)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 17896)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5157 (class 0 OID 0)
-- Dependencies: 230
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 229 (class 1259 OID 17882)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 17867)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 17866)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5158 (class 0 OID 0)
-- Dependencies: 227
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 220 (class 1259 OID 17797)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 17796)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5159 (class 0 OID 0)
-- Dependencies: 219
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 223 (class 1259 OID 17823)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 17832)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 17807)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    phone character varying(25),
    role character varying(20) DEFAULT 'user'::character varying NOT NULL,
    avatar character varying(255),
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 17806)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5160 (class 0 OID 0)
-- Dependencies: 221
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4923 (class 2604 OID 17960)
-- Name: campaigns id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns ALTER COLUMN id SET DEFAULT nextval('public.campaigns_id_seq'::regclass);


--
-- TOC entry 4917 (class 2604 OID 17920)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4918 (class 2604 OID 17934)
-- Name: disasters id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disasters ALTER COLUMN id SET DEFAULT nextval('public.disasters_id_seq'::regclass);


--
-- TOC entry 4926 (class 2604 OID 17997)
-- Name: donations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donations ALTER COLUMN id SET DEFAULT nextval('public.donations_id_seq'::regclass);


--
-- TOC entry 4915 (class 2604 OID 17900)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4914 (class 2604 OID 17870)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4911 (class 2604 OID 17800)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4912 (class 2604 OID 17810)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5133 (class 0 OID 17844)
-- Dependencies: 225
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 5134 (class 0 OID 17855)
-- Dependencies: 226
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 5145 (class 0 OID 17957)
-- Dependencies: 237
-- Data for Name: campaigns; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.campaigns (id, category_id, disaster_id, user_id, title, slug, description, target_amount, collected_amount, deadline, status, thumbnail, created_at, updated_at) FROM stdin;
2	2	2	1	Bangun Kembali Jaringan Air Bersih & Sanitasi Desa Terdampak Banjir Agam	air-bersih-sanitasi-desa-terdampak-banjir-agam	Pascabanjir bandang, warga kesulitan memperoleh air bersih untuk kebutuhan memasak dan sanitasi harian. Kampanye ini berfokus pada pembangunan kembali jaringan pipa air bersih masyarakat dan penyediaan tangki filtrasi komunal.	120000000.00	84000000.00	2026-11-22	active	https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-23 22:14:20
3	4	3	1	Ruang Belajar & Paket Sekolah untuk Anak Penyintas Gempa Garut	ruang-belajar-paket-sekolah-penyintas-gempa-garut	Jangan biarkan mimpi anak-anak terhenti karena bencana. Mari hadirkan tenda belajar yang nyaman, buku bacaan, seragam, serta kegiatan trauma healing agar senyum mereka kembali pulih.	75000000.00	61300000.00	2026-11-07	active	https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-28 13:39:09
1	1	1	1	Darurat Udara Bersih & Dapur Umum Penyintas Lereng Semeru	darurat-udara-bersih-dapur-umum-semeru	Kebaikan yang tak terlihat namun nyata manfaatnya. Mari bersama menyediakan paket masker respirator, tabung oksigen portabel, perlengkapan bayi, dan operasional dapur umum selama 14 hari masa tanggap darurat bagi keluarga di lereng Semeru.\n\nSetiap donasi yang terkumpul akan disalurkan secara transparan melalui posko lapangan Niskala bekerja sama dengan relawan lokal.	150000000.00	93520000.00	2026-11-13	active	https://images.unsplash.com/photo-1593113630400-ea4288922497?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-28 13:49:48
\.


--
-- TOC entry 5141 (class 0 OID 17917)
-- Dependencies: 233
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, slug, description, icon, created_at, updated_at) FROM stdin;
1	Erupsi & Vulkanik	erupsi-vulkanik	Penanganan dampak aktivitas gunung berapi, awan panas, dan banjir lahar dingin.	mountain	2026-10-23 22:14:20	2026-10-23 22:14:20
2	Banjir & Longsor	banjir-longsor	Respon cepat bencana hidrometeorologi, banjir bandang, dan tanah longsor.	cloud-rain	2026-10-23 22:14:20	2026-10-23 22:14:20
3	Gempa Bumi	gempa-bumi	Tanggap darurat dan rehabilitasi pascagempa bumi di wilayah Nusantara.	activity	2026-10-23 22:14:20	2026-10-23 22:14:20
4	Pemulihan Sosial & Medis	pemulihan-sosial-medis	Dukungan logistik, dapur umum, trauma healing, dan layanan kesehatan penyintas.	heart-handshake	2026-10-23 22:14:20	2026-10-23 22:14:20
\.


--
-- TOC entry 5143 (class 0 OID 17931)
-- Dependencies: 235
-- Data for Name: disasters; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.disasters (id, category_id, title, slug, location, occurred_at, status, summary, content, thumbnail, created_at, updated_at, latitude, longitude, impact_radius_km) FROM stdin;
1	1	Erupsi & Guguran Awan Panas Lereng Semeru	erupsi-guguran-awan-panas-lereng-semeru	Kab. Lumajang, Jawa Timur	2026-10-19 22:14:20	tanggap_darurat	Peningkatan aktivitas vulkanik disertai hujan abu tebal berdampak pada 1.450 warga di tiga desa lereng gunung. Kebutuhan mendesak meliputi masker medis N95, air bersih, dan selimut hangat.	Peningkatan aktivitas vulkanik kembali terjadi dan mengakibatkan hujan abu vulkanik di beberapa titik pemukiman warga.\n\nTim relawan gabungan bersama BPBD setempat telah mendirikan posko pengungsian terpadu untuk memprioritaskan lansia, ibu hamil, serta anak-anak. Saat ini jalur distribusi logistik terus dibuka agar suplai makanan siap saji, air bersih, serta perlengkapan tidur dapat menjangkau posko-posko pengungsian.	https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-23 22:14:20	-8.1077170	112.9224070	12.50
2	2	Banjir Bandang & Longsor Wilayah Agam	banjir-bandang-longsor-wilayah-agam	Kab. Agam, Sumatera Barat	2026-10-14 22:14:20	pemulihan	Curah hujan tinggi memicu luapan sungai dan material longsor yang menutup akses jalan desa serta merusak puluhan rumah warga dan fasilitas air bersih.	Intensitas hujan tinggi yang berlangsung selama dua hari berturut-turut menyebabkan debit sungai meluap dengan cepat.\n\nSaat ini fokus penanganan berada pada fase pemulihan awal, termasuk pembersihan fasilitas umum, penyediaan instalasi air bersih darurat, serta pemulihan ruang belajar sementara bagi anak-anak terdampak.	https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-23 22:14:20	-0.3055560	100.3691670	8.00
3	3	Gempa Tektonik Dangkal Wilayah Garut Selatan	gempa-tektonik-dangkal-wilayah-garut-selatan	Kab. Garut, Jawa Barat	2026-10-09 22:14:20	pemulihan	Guncangan gempa menyebabkan keretakan dan kerusakan pada sejumlah rumah warga serta bangunan sekolah dasar di daerah perbukitan.	Gempa bumi tektonik dangkal dirasakan kuat oleh warga sekitar pada malam hari. Meski tidak berpotensi tsunami, sejumlah rumah dengan struktur rentan mengalami kerusakan ringan hingga sedang.\n\nWarga membutuhkan bantuan material perbaikan tempat tinggal sementara, tenda keluarga, serta pendampingan psikososial untuk anak-anak.	https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1000&q=80	2026-10-23 22:14:20	2026-10-23 22:14:20	-7.2279060	107.9086990	15.00
4	2	Banjir	banjir-mwmm	Karawang Barat	2026-11-04 13:24:00	tanggap_darurat	Banjir	Banjir	https://wastecinternational.com/wp-content/uploads/2025/12/banjir-sumatera-1024x683.jpg	2026-11-04 13:28:45	2026-11-04 13:35:01	-6.3214408	107.2526550	2.00
\.


--
-- TOC entry 5147 (class 0 OID 17994)
-- Dependencies: 239
-- Data for Name: donations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.donations (id, campaign_id, user_id, invoice_number, donor_name, donor_email, is_anonymous, amount, message, payment_method, status, verified_at, created_at, updated_at) FROM stdin;
1	1	2	NSK-20261023-0001	Raka Pratama	raka@niskala.id	f	1500000.00	Semoga saudara-saudara kita di Lumajang selalu diberikan kesehatan dan keselamatan.	QRIS	verified	2026-10-23 17:14:20	2026-10-23 22:14:20	2026-10-23 22:14:20
2	1	\N	NSK-20261023-0002	Budi Santoso	budi@example.com	t	500000.00	Titip doa dan sedikit rezeki untuk dapur umum di sana.	Transfer BCA	verified	2026-10-23 19:14:20	2026-10-23 22:14:20	2026-10-23 22:14:20
3	2	3	NSK-20261023-0003	Ayu Lestari	ayu@niskala.id	f	2000000.00	Semoga instalasi air bersihnya lekas rampung dan bermanfaat bagi warga.	Transfer Mandiri	verified	2026-10-23 20:14:20	2026-10-23 22:14:20	2026-10-23 22:14:20
4	1	\N	NSK-20261023-RROFL	Firdaus	rafly.firdaus.fmb@krw.horizon.ac.id	f	500000.00	\N	QRIS	verified	2026-10-23 22:23:10	2026-10-23 22:23:10	2026-10-23 22:23:10
5	3	\N	NSK-20261028-L34N2	Mas Robby	robby@gmail.com	f	50000.00	Semoga projectny lancar	QRIS	verified	2026-10-28 13:39:09	2026-10-28 13:39:09	2026-10-28 13:39:09
6	1	2	NSK-20261028-4QAOE	Raka Pratama	raka@niskala.id	f	520000.00	Semoga lekas membaik	QRIS	verified	2026-10-28 13:49:48	2026-10-28 13:49:48	2026-10-28 13:49:48
\.


--
-- TOC entry 5139 (class 0 OID 17897)
-- Dependencies: 231
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 5137 (class 0 OID 17882)
-- Dependencies: 229
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- TOC entry 5136 (class 0 OID 17867)
-- Dependencies: 228
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- TOC entry 5128 (class 0 OID 17797)
-- Dependencies: 220
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_10_23_122742_create_categories_table	1
5	2026_10_23_122751_create_disasters_table	1
6	2026_10_23_122759_create_campaigns_table	1
7	2026_10_23_122807_create_donations_table	1
8	2026_10_23_182245_add_map_coordinates_to_disasters_table	1
\.


--
-- TOC entry 5131 (class 0 OID 17823)
-- Dependencies: 223
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 5132 (class 0 OID 17832)
-- Dependencies: 224
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
Gmx2tfzEUMd1YzMd5ZOiOv9T58CEHzKsAYHieifm	2	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJWdG5NVE9tS2dHd0NVOFhYV0dKYWppUDR6NXdtRFFYb0hMTWlCY2pLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9rYW1wYW55ZVwvZGFydXJhdC11ZGFyYS1iZXJzaWgtZGFwdXItdW11bS1zZW1lcnUiLCJyb3V0ZSI6ImNhbXBhaWducy5zaG93In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsInBhc3N3b3JkX2hhc2hfd2ViIjoiNzQ4MGNiYmIzMGIxZTFlYThiYTA1NmEyMzE0YTdmMmI3ZDA3ZWM5Y2VkZTk0M2NiYmY3MTY5MDVkYzg5N2RjMiJ9	1793195390
teDgR01ExeWBA60Nc52agQG16p2D4NAWC7UJ4bcE	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0	eyJfdG9rZW4iOiI1dENSWjhpRERWOUJiMWN0UTJQZm51aVliQTBaNlZIWHdDTmFRYmtLIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2JlbmNhbmFcL2Jhbmppci1td21tIiwicm91dGUiOiJkaXNhc3RlcnMuc2hvdyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwicGFzc3dvcmRfaGFzaF93ZWIiOiJhNDlkMzhlNTc1ZTA5MDcyYTFkZWJiYTA4ZDE4MDNmYWQ3ZTUyODdiMDg0OWEyMTAwYzExZjdmMDlkN2JkYWMwIn0=	1793799431
SXqzmgodVM6QRLtmowSpnLwokcBKtt60rDU2kV6d	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJHT2FyaGRMU1duRHpkY0MyYkdEVXZpV3R5amc0a0ZnV0MzQjdlSFV2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=	1793194648
\.


--
-- TOC entry 5130 (class 0 OID 17807)
-- Dependencies: 222
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, phone, role, avatar, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	Admin Utama Niskala	admin@niskala.id	081234567890	admin	\N	\N	$2y$12$PjhuiCiUb6PxXdAgHUe7ju3GkSybDWQ3/CsvgAGC58Fq1E/r6cmx2	\N	2026-10-23 22:14:19	2026-10-23 22:14:19
2	Raka Pratama	raka@niskala.id	081298765432	user	\N	\N	$2y$12$Z/3gVeUouXEsWHUmyiCyNOXs/1q8tJHaq1tjVVelM7E4mzevmYv6C	\N	2026-10-23 22:14:19	2026-10-23 22:14:19
3	Ayu Lestari	ayu@niskala.id	081355667788	user	\N	\N	$2y$12$6bhb8gj.qUdXdIjR0V/2kuXzg2PdN.9X.IS8SPmuUSgasOgYVUoJS	\N	2026-10-23 22:14:20	2026-10-23 22:14:20
\.


--
-- TOC entry 5161 (class 0 OID 0)
-- Dependencies: 236
-- Name: campaigns_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.campaigns_id_seq', 3, true);


--
-- TOC entry 5162 (class 0 OID 0)
-- Dependencies: 232
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 4, true);


--
-- TOC entry 5163 (class 0 OID 0)
-- Dependencies: 234
-- Name: disasters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.disasters_id_seq', 4, true);


--
-- TOC entry 5164 (class 0 OID 0)
-- Dependencies: 238
-- Name: donations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.donations_id_seq', 6, true);


--
-- TOC entry 5165 (class 0 OID 0)
-- Dependencies: 230
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 5166 (class 0 OID 0)
-- Dependencies: 227
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 5167 (class 0 OID 0)
-- Dependencies: 219
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 8, true);


--
-- TOC entry 5168 (class 0 OID 0)
-- Dependencies: 221
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- TOC entry 4947 (class 2606 OID 17864)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 4944 (class 2606 OID 17853)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4967 (class 2606 OID 17975)
-- Name: campaigns campaigns_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns
    ADD CONSTRAINT campaigns_pkey PRIMARY KEY (id);


--
-- TOC entry 4969 (class 2606 OID 17992)
-- Name: campaigns campaigns_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns
    ADD CONSTRAINT campaigns_slug_unique UNIQUE (slug);


--
-- TOC entry 4959 (class 2606 OID 17927)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 4961 (class 2606 OID 17929)
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- TOC entry 4963 (class 2606 OID 17948)
-- Name: disasters disasters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disasters
    ADD CONSTRAINT disasters_pkey PRIMARY KEY (id);


--
-- TOC entry 4965 (class 2606 OID 17955)
-- Name: disasters disasters_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disasters
    ADD CONSTRAINT disasters_slug_unique UNIQUE (slug);


--
-- TOC entry 4971 (class 2606 OID 18024)
-- Name: donations donations_invoice_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donations
    ADD CONSTRAINT donations_invoice_number_unique UNIQUE (invoice_number);


--
-- TOC entry 4973 (class 2606 OID 18012)
-- Name: donations donations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donations
    ADD CONSTRAINT donations_pkey PRIMARY KEY (id);


--
-- TOC entry 4955 (class 2606 OID 17912)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4957 (class 2606 OID 17915)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4952 (class 2606 OID 17895)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 4949 (class 2606 OID 17880)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4931 (class 2606 OID 17805)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4937 (class 2606 OID 17831)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 4940 (class 2606 OID 17841)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 4933 (class 2606 OID 17822)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4935 (class 2606 OID 17820)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4942 (class 1259 OID 17854)
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- TOC entry 4945 (class 1259 OID 17865)
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- TOC entry 4953 (class 1259 OID 17913)
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- TOC entry 4950 (class 1259 OID 17881)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 4938 (class 1259 OID 17843)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 4941 (class 1259 OID 17842)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 4975 (class 2606 OID 17976)
-- Name: campaigns campaigns_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns
    ADD CONSTRAINT campaigns_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 4976 (class 2606 OID 17981)
-- Name: campaigns campaigns_disaster_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns
    ADD CONSTRAINT campaigns_disaster_id_foreign FOREIGN KEY (disaster_id) REFERENCES public.disasters(id) ON DELETE SET NULL;


--
-- TOC entry 4977 (class 2606 OID 17986)
-- Name: campaigns campaigns_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaigns
    ADD CONSTRAINT campaigns_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 4974 (class 2606 OID 17949)
-- Name: disasters disasters_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disasters
    ADD CONSTRAINT disasters_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 4978 (class 2606 OID 18013)
-- Name: donations donations_campaign_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donations
    ADD CONSTRAINT donations_campaign_id_foreign FOREIGN KEY (campaign_id) REFERENCES public.campaigns(id) ON DELETE CASCADE;


--
-- TOC entry 4979 (class 2606 OID 18018)
-- Name: donations donations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donations
    ADD CONSTRAINT donations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


-- Completed on 2026-11-06 19:22:36

--
-- PostgreSQL database dump complete
--

\unrestrict cy0d0EGPh27wxGpbSB5id0I6pf21xCh4EtS3OItqaXKSfORzxjgdbgudfXh2Izx

