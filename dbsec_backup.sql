PGDMP                      |         
   dbsecurity    16.1    16.1 /    -           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            .           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            /           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            0           1262    16398 
   dbsecurity    DATABASE     �   CREATE DATABASE dbsecurity WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE dbsecurity;
                postgres    false            �            1259    16472 	   bookmarks    TABLE        CREATE TABLE public.bookmarks (
    student_id character varying(20) NOT NULL,
    course_id character varying(20) NOT NULL
);
    DROP TABLE public.bookmarks;
       public         heap    postgres    false            �            1259    16485    comments    TABLE     )  CREATE TABLE public.comments (
    comment_id character varying(20) NOT NULL,
    content_id character varying(20) NOT NULL,
    student_id character varying(20) NOT NULL,
    tutor_id character varying(20),
    comment character varying(1000),
    date date,
    user_id character varying(20)
);
    DROP TABLE public.comments;
       public         heap    postgres    false            �            1259    16447    content    TABLE     J  CREATE TABLE public.content (
    content_id character varying(20) NOT NULL,
    tutor_id character varying(20) NOT NULL,
    course_id character varying(20) NOT NULL,
    "title " character varying(50),
    description character varying(50),
    video character varying(50),
    thumbnail character varying(50),
    date date
);
    DROP TABLE public.content;
       public         heap    postgres    false            �            1259    16424    courses    TABLE       CREATE TABLE public.courses (
    course_id character varying(20) NOT NULL,
    tutor_id character varying(20) NOT NULL,
    title character varying(50),
    description character varying(50),
    thumbnail character varying(50),
    date date,
    status character varying(50)
);
    DROP TABLE public.courses;
       public         heap    postgres    false            �            1259    16434    likes    TABLE     �   CREATE TABLE public.likes (
    student_id character varying(20) NOT NULL,
    tutor_id character varying(20) NOT NULL,
    content_id character varying(20) NOT NULL,
    user_id character varying(20)
);
    DROP TABLE public.likes;
       public         heap    postgres    false            �            1259    16467    student_support_staffs    TABLE     �   CREATE TABLE public.student_support_staffs (
    staff_id character varying(20) NOT NULL,
    name character varying(50),
    email character varying(50),
    password character varying(50),
    image character varying(50)
);
 *   DROP TABLE public.student_support_staffs;
       public         heap    postgres    false            �            1259    16399    students    TABLE     �   CREATE TABLE public.students (
    student_id character varying(20) NOT NULL,
    name character varying(50) NOT NULL,
    image character varying(50) NOT NULL
);
    DROP TABLE public.students;
       public         heap    postgres    false            �            1259    16507    support_staff_message    TABLE     �   CREATE TABLE public.support_staff_message (
    message_id character varying(20) NOT NULL,
    staff_id character varying(20) NOT NULL,
    student_id character varying(20) NOT NULL,
    message character varying(1000),
    date date
);
 )   DROP TABLE public.support_staff_message;
       public         heap    postgres    false            �            1259    16414    tutors    TABLE     �   CREATE TABLE public.tutors (
    tutor_id character varying(20) NOT NULL,
    name character varying(50),
    email character varying(50),
    password character varying(50),
    image character varying(50),
    profession character varying(50)
);
    DROP TABLE public.tutors;
       public         heap    postgres    false            �            1259    16404    users    TABLE       CREATE TABLE public.users (
    user_id character varying(20) NOT NULL,
    student_id character varying(20),
    tutor_id character varying(20),
    staff_id character varying(20),
    email character varying(50),
    password character varying(50),
    role character varying(50)
);
    DROP TABLE public.users;
       public         heap    postgres    false            (          0    16472 	   bookmarks 
   TABLE DATA           :   COPY public.bookmarks (student_id, course_id) FROM stdin;
    public          postgres    false    222   �>       )          0    16485    comments 
   TABLE DATA           h   COPY public.comments (comment_id, content_id, student_id, tutor_id, comment, date, user_id) FROM stdin;
    public          postgres    false    223   �>       &          0    16447    content 
   TABLE DATA           q   COPY public.content (content_id, tutor_id, course_id, "title ", description, video, thumbnail, date) FROM stdin;
    public          postgres    false    220   �>       $          0    16424    courses 
   TABLE DATA           c   COPY public.courses (course_id, tutor_id, title, description, thumbnail, date, status) FROM stdin;
    public          postgres    false    218   �>       %          0    16434    likes 
   TABLE DATA           J   COPY public.likes (student_id, tutor_id, content_id, user_id) FROM stdin;
    public          postgres    false    219   ?       '          0    16467    student_support_staffs 
   TABLE DATA           X   COPY public.student_support_staffs (staff_id, name, email, password, image) FROM stdin;
    public          postgres    false    221   3?       !          0    16399    students 
   TABLE DATA           ;   COPY public.students (student_id, name, image) FROM stdin;
    public          postgres    false    215   P?       *          0    16507    support_staff_message 
   TABLE DATA           `   COPY public.support_staff_message (message_id, staff_id, student_id, message, date) FROM stdin;
    public          postgres    false    224   A       #          0    16414    tutors 
   TABLE DATA           T   COPY public.tutors (tutor_id, name, email, password, image, profession) FROM stdin;
    public          postgres    false    217   %A       "          0    16404    users 
   TABLE DATA           _   COPY public.users (user_id, student_id, tutor_id, staff_id, email, password, role) FROM stdin;
    public          postgres    false    216   B       �           2606    16491    comments Comments_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_pkey" PRIMARY KEY (comment_id);
 B   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_pkey";
       public            postgres    false    223            |           2606    16451    content Content_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_pkey" PRIMARY KEY (content_id);
 @   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_pkey";
       public            postgres    false    220            z           2606    16428    courses Courses_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.courses
    ADD CONSTRAINT "Courses_pkey" PRIMARY KEY (course_id);
 @   ALTER TABLE ONLY public.courses DROP CONSTRAINT "Courses_pkey";
       public            postgres    false    218            ~           2606    16471 2   student_support_staffs Student Support Staffs_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.student_support_staffs
    ADD CONSTRAINT "Student Support Staffs_pkey" PRIMARY KEY (staff_id);
 ^   ALTER TABLE ONLY public.student_support_staffs DROP CONSTRAINT "Student Support Staffs_pkey";
       public            postgres    false    221            �           2606    16513 0   support_staff_message Support Staff Message_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_pkey" PRIMARY KEY (message_id);
 \   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_pkey";
       public            postgres    false    224            x           2606    16418    tutors Tutors_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.tutors
    ADD CONSTRAINT "Tutors_pkey" PRIMARY KEY (tutor_id);
 >   ALTER TABLE ONLY public.tutors DROP CONSTRAINT "Tutors_pkey";
       public            postgres    false    217            v           2606    16408    users Users_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY (user_id);
 <   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_pkey";
       public            postgres    false    216            t           2606    16403    students stduents_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.students
    ADD CONSTRAINT stduents_pkey PRIMARY KEY (student_id);
 @   ALTER TABLE ONLY public.students DROP CONSTRAINT stduents_pkey;
       public            postgres    false    215            �           2606    16480 "   bookmarks Bookmarks_Course ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bookmarks
    ADD CONSTRAINT "Bookmarks_Course ID_fkey" FOREIGN KEY (course_id) REFERENCES public.courses(course_id) NOT VALID;
 N   ALTER TABLE ONLY public.bookmarks DROP CONSTRAINT "Bookmarks_Course ID_fkey";
       public          postgres    false    4730    218    222            �           2606    16475 #   bookmarks Bookmarks_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bookmarks
    ADD CONSTRAINT "Bookmarks_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 O   ALTER TABLE ONLY public.bookmarks DROP CONSTRAINT "Bookmarks_Student ID_fkey";
       public          postgres    false    222    4724    215            �           2606    16492 !   comments Comments_Content ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Content ID_fkey" FOREIGN KEY (content_id) REFERENCES public.content(content_id);
 M   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Content ID_fkey";
       public          postgres    false    220    4732    223            �           2606    16497 !   comments Comments_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id) NOT VALID;
 M   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Student ID_fkey";
       public          postgres    false    223    215    4724            �           2606    16502    comments Comments_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 K   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Tutor ID_fkey";
       public          postgres    false    223    217    4728            �           2606    16457    content Content_Course ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_Course ID_fkey" FOREIGN KEY (course_id) REFERENCES public.courses(course_id) NOT VALID;
 J   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_Course ID_fkey";
       public          postgres    false    218    220    4730            �           2606    16452    content Content_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id);
 I   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_Tutor ID_fkey";
       public          postgres    false    217    220    4728            �           2606    16429    courses Courses_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.courses
    ADD CONSTRAINT "Courses_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id);
 I   ALTER TABLE ONLY public.courses DROP CONSTRAINT "Courses_Tutor ID_fkey";
       public          postgres    false    218    217    4728            �           2606    16462    likes Likes_Content ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Content ID_fkey" FOREIGN KEY (content_id) REFERENCES public.content(content_id) NOT VALID;
 G   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Content ID_fkey";
       public          postgres    false    4732    219    220            �           2606    16437    likes Likes_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 G   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Student ID_fkey";
       public          postgres    false    4724    215    219            �           2606    16442    likes Likes_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 E   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Tutor ID_fkey";
       public          postgres    false    219    4728    217            �           2606    16514 9   support_staff_message Support Staff Message_Staff ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_Staff ID_fkey" FOREIGN KEY (staff_id) REFERENCES public.student_support_staffs(staff_id);
 e   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_Staff ID_fkey";
       public          postgres    false    221    4734    224            �           2606    16519 ;   support_staff_message Support Staff Message_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id) NOT VALID;
 g   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_Student ID_fkey";
       public          postgres    false    224    215    4724            �           2606    16409    users Users_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 G   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_Student ID_fkey";
       public          postgres    false    4724    216    215            �           2606    16419    users Users_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_Tutor ID_fkey";
       public          postgres    false    216    217    4728            (      x������ � �      )      x������ � �      &      x������ � �      $      x������ � �      %      x������ � �      '      x������ � �      !   �  x�u�I��0 �5��X)���D���0��0�����5����7&>2]!*�p���f-�*XKt���(4�gzc;摫��o�6]^Fy�Pꩄ����sg��_���Uޮ��Z
� H��>� ��5��(w��ɦH�d��ʓJ��4!ጞvHfljC��T�#�u��<B-Imɷ�i�h/�XY0���+��3U#�J8�w�!.�Cug@�����F���D����no���Ȟ'ʈ�˖^���\ǡ	�b�a���6�Ow8��l�A���t�㺾����Ӯg��q���H^uB���ӛ�Ayz�<,��wPP�ʅ��;��j/��7�~��R����8����h!�r�芭���&Nom6�{���$#�������ݭ)�΃�J�t���٬V�_�ك      *      x������ � �      #   �   x��λV�0  �9|�_�!b(�䴂�Ah)�$$��R���:t�x�[��ʉ���\��6���t>��]��B�_0��+:X�uO����,"Ƕ\$�����{,(�q$8�B���go8X��e�/�>��Q�`#�D�G1�6f�'�)64h(<+r-!������}X��v�\=��e%yu���I�V�P�����Z����i!�s^L3M����4��V��      "   �  x���͎�0��5\�W@
�݀���hp2JˏHA)*^���I��sΘt�4ϻ����=b-w>LT�3j7�c�s�CBۢ<���&,I��sB��
�B[p��^�Z��������Χ�<VO�g�匂oh	�ɷ�� a De��d)Tı%�$b�)�BR�"${�[H���;ci���+}U]d�FN����9���J�_e��b�C��
��J�C/�g�\E�JB=���jP"��G%DwʪA��k���ø��Z���˹���u`=��ܱs�Z�X�v�����5�bOhކ�!A�Wy1~ZP���IyҦ��ֆ��P�7�)
�F�D�P� �:\R9'�C�LWǶ#�)(�&����XdNY%�Ӱ�K��wAc RKC�d����{���ۓapW�e,X��ꡇ��U�&��:������&���2-�?٨g͙�x��S3T�     