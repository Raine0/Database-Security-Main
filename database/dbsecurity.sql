PGDMP      %                |         
   dbsecurity    16.1    16.1 5    3           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            4           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            5           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            6           1262    16398 
   dbsecurity    DATABASE     �   CREATE DATABASE dbsecurity WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE dbsecurity;
                postgres    false            �            1255    16527    add_date_to_content()    FUNCTION     �   CREATE FUNCTION public.add_date_to_content() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.date := CURRENT_DATE;
    RETURN NEW;
END;
$$;
 ,   DROP FUNCTION public.add_date_to_content();
       public          postgres    false            �            1255    16529    set_comment_date()    FUNCTION       CREATE FUNCTION public.set_comment_date() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.date := CURRENT_DATE;
    ELSIF TG_OP = 'UPDATE' THEN
        NEW.date := CURRENT_DATE;
    END IF;
    RETURN NEW;
END;
$$;
 )   DROP FUNCTION public.set_comment_date();
       public          postgres    false            �            1255    16525    set_course_date()    FUNCTION     �   CREATE FUNCTION public.set_course_date() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.date := CURRENT_DATE;
    RETURN NEW;
END;
$$;
 (   DROP FUNCTION public.set_course_date();
       public          postgres    false            �            1259    16472 	   bookmarks    TABLE        CREATE TABLE public.bookmarks (
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
       public         heap    postgres    false            �            1259    16447    content    TABLE     i  CREATE TABLE public.content (
    content_id character varying(20) NOT NULL,
    tutor_id character varying(20) NOT NULL,
    course_id character varying(20) NOT NULL,
    title character varying(50),
    description character varying(50),
    video character varying(50),
    thumbnail character varying(50),
    date date,
    status character varying(50)
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
    user_id character varying(20) NOT NULL
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
       public         heap    postgres    false            .          0    16472 	   bookmarks 
   TABLE DATA           :   COPY public.bookmarks (student_id, course_id) FROM stdin;
    public          postgres    false    222   `G       /          0    16485    comments 
   TABLE DATA           h   COPY public.comments (comment_id, content_id, student_id, tutor_id, comment, date, user_id) FROM stdin;
    public          postgres    false    223   H       ,          0    16447    content 
   TABLE DATA           v   COPY public.content (content_id, tutor_id, course_id, title, description, video, thumbnail, date, status) FROM stdin;
    public          postgres    false    220   )I       *          0    16424    courses 
   TABLE DATA           c   COPY public.courses (course_id, tutor_id, title, description, thumbnail, date, status) FROM stdin;
    public          postgres    false    218   L       +          0    16434    likes 
   TABLE DATA           J   COPY public.likes (student_id, tutor_id, content_id, user_id) FROM stdin;
    public          postgres    false    219   uM       -          0    16467    student_support_staffs 
   TABLE DATA           X   COPY public.student_support_staffs (staff_id, name, email, password, image) FROM stdin;
    public          postgres    false    221   'N       '          0    16399    students 
   TABLE DATA           ;   COPY public.students (student_id, name, image) FROM stdin;
    public          postgres    false    215   DN       0          0    16507    support_staff_message 
   TABLE DATA           `   COPY public.support_staff_message (message_id, staff_id, student_id, message, date) FROM stdin;
    public          postgres    false    224   )O       )          0    16414    tutors 
   TABLE DATA           T   COPY public.tutors (tutor_id, name, email, password, image, profession) FROM stdin;
    public          postgres    false    217   FO       (          0    16404    users 
   TABLE DATA           _   COPY public.users (user_id, student_id, tutor_id, staff_id, email, password, role) FROM stdin;
    public          postgres    false    216   P       �           2606    16491    comments Comments_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_pkey" PRIMARY KEY (comment_id);
 B   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_pkey";
       public            postgres    false    223                       2606    16451    content Content_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_pkey" PRIMARY KEY (content_id);
 @   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_pkey";
       public            postgres    false    220            }           2606    16428    courses Courses_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.courses
    ADD CONSTRAINT "Courses_pkey" PRIMARY KEY (course_id);
 @   ALTER TABLE ONLY public.courses DROP CONSTRAINT "Courses_pkey";
       public            postgres    false    218            �           2606    16471 2   student_support_staffs Student Support Staffs_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.student_support_staffs
    ADD CONSTRAINT "Student Support Staffs_pkey" PRIMARY KEY (staff_id);
 ^   ALTER TABLE ONLY public.student_support_staffs DROP CONSTRAINT "Student Support Staffs_pkey";
       public            postgres    false    221            �           2606    16513 0   support_staff_message Support Staff Message_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_pkey" PRIMARY KEY (message_id);
 \   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_pkey";
       public            postgres    false    224            {           2606    16418    tutors Tutors_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.tutors
    ADD CONSTRAINT "Tutors_pkey" PRIMARY KEY (tutor_id);
 >   ALTER TABLE ONLY public.tutors DROP CONSTRAINT "Tutors_pkey";
       public            postgres    false    217            y           2606    16408    users Users_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY (user_id);
 <   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_pkey";
       public            postgres    false    216            w           2606    16403    students stduents_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.students
    ADD CONSTRAINT stduents_pkey PRIMARY KEY (student_id);
 @   ALTER TABLE ONLY public.students DROP CONSTRAINT stduents_pkey;
       public            postgres    false    215            �           2620    16528    content content_date_trigger    TRIGGER     �   CREATE TRIGGER content_date_trigger BEFORE INSERT ON public.content FOR EACH ROW EXECUTE FUNCTION public.add_date_to_content();
 5   DROP TRIGGER content_date_trigger ON public.content;
       public          postgres    false    227    220            �           2620    16530 !   comments set_comment_date_trigger    TRIGGER     �   CREATE TRIGGER set_comment_date_trigger BEFORE INSERT OR UPDATE ON public.comments FOR EACH ROW EXECUTE FUNCTION public.set_comment_date();
 :   DROP TRIGGER set_comment_date_trigger ON public.comments;
       public          postgres    false    226    223            �           2620    16526    courses trigger_set_course_date    TRIGGER        CREATE TRIGGER trigger_set_course_date BEFORE INSERT ON public.courses FOR EACH ROW EXECUTE FUNCTION public.set_course_date();
 8   DROP TRIGGER trigger_set_course_date ON public.courses;
       public          postgres    false    218    225            �           2606    16480 "   bookmarks Bookmarks_Course ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bookmarks
    ADD CONSTRAINT "Bookmarks_Course ID_fkey" FOREIGN KEY (course_id) REFERENCES public.courses(course_id) NOT VALID;
 N   ALTER TABLE ONLY public.bookmarks DROP CONSTRAINT "Bookmarks_Course ID_fkey";
       public          postgres    false    4733    222    218            �           2606    16475 #   bookmarks Bookmarks_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bookmarks
    ADD CONSTRAINT "Bookmarks_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 O   ALTER TABLE ONLY public.bookmarks DROP CONSTRAINT "Bookmarks_Student ID_fkey";
       public          postgres    false    215    222    4727            �           2606    16492 !   comments Comments_Content ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Content ID_fkey" FOREIGN KEY (content_id) REFERENCES public.content(content_id);
 M   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Content ID_fkey";
       public          postgres    false    4735    223    220            �           2606    16497 !   comments Comments_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id) NOT VALID;
 M   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Student ID_fkey";
       public          postgres    false    215    4727    223            �           2606    16502    comments Comments_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.comments
    ADD CONSTRAINT "Comments_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 K   ALTER TABLE ONLY public.comments DROP CONSTRAINT "Comments_Tutor ID_fkey";
       public          postgres    false    223    217    4731            �           2606    16457    content Content_Course ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_Course ID_fkey" FOREIGN KEY (course_id) REFERENCES public.courses(course_id) NOT VALID;
 J   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_Course ID_fkey";
       public          postgres    false    4733    218    220            �           2606    16452    content Content_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.content
    ADD CONSTRAINT "Content_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id);
 I   ALTER TABLE ONLY public.content DROP CONSTRAINT "Content_Tutor ID_fkey";
       public          postgres    false    220    4731    217            �           2606    16429    courses Courses_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.courses
    ADD CONSTRAINT "Courses_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id);
 I   ALTER TABLE ONLY public.courses DROP CONSTRAINT "Courses_Tutor ID_fkey";
       public          postgres    false    4731    218    217            �           2606    16462    likes Likes_Content ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Content ID_fkey" FOREIGN KEY (content_id) REFERENCES public.content(content_id) NOT VALID;
 G   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Content ID_fkey";
       public          postgres    false    219    4735    220            �           2606    16437    likes Likes_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 G   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Student ID_fkey";
       public          postgres    false    219    215    4727            �           2606    16442    likes Likes_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.likes
    ADD CONSTRAINT "Likes_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 E   ALTER TABLE ONLY public.likes DROP CONSTRAINT "Likes_Tutor ID_fkey";
       public          postgres    false    217    4731    219            �           2606    16514 9   support_staff_message Support Staff Message_Staff ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_Staff ID_fkey" FOREIGN KEY (staff_id) REFERENCES public.student_support_staffs(staff_id);
 e   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_Staff ID_fkey";
       public          postgres    false    224    221    4737            �           2606    16519 ;   support_staff_message Support Staff Message_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.support_staff_message
    ADD CONSTRAINT "Support Staff Message_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id) NOT VALID;
 g   ALTER TABLE ONLY public.support_staff_message DROP CONSTRAINT "Support Staff Message_Student ID_fkey";
       public          postgres    false    4727    224    215            �           2606    16409    users Users_Student ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_Student ID_fkey" FOREIGN KEY (student_id) REFERENCES public.students(student_id);
 G   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_Student ID_fkey";
       public          postgres    false    215    4727    216            �           2606    16419    users Users_Tutor ID_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT "Users_Tutor ID_fkey" FOREIGN KEY (tutor_id) REFERENCES public.tutors(tutor_id) NOT VALID;
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT "Users_Tutor ID_fkey";
       public          postgres    false    4731    216    217            .   �   x��0Oq�K/�p426��-7�1�4/v�6�+1�0	,,,L�
�*7))��.��tLt4�L��p�H��4q4�,�����(t*��f&�*���\sJM-��]��-݊�����4I���
�	�J
Nv��*��N�f��qqq ��Q�      /     x����n�0 ���)|�R��Q��H�(�](��ZT6���m��Y��O�b5��[BU���Į���A�����b=I�1�	Z���b�Z�ҙq�U� ��e��!况��P��-�)OGD�""}�XE�x�1�;�����^�pYo���]��{����,W�D$�����i��6���}?����`�� ;l���� SM���$�D^G�i09ĭL�xÀ��_�qU�W�ewu<�qW�ٚ(/t�t-�.y[h����_�����C�ۓ�(�1��      ,   �  x���K��@��5�+&��t�@�%X �  ��Z��E�˯���d��t/�o�$�M��Uzu�𶣯P��fi~e�D�:�l֫�>�f�I�z���E+H#w��m����㏟̧�w#��#̌��݀�˚��YZC�V���$��,0���z� �_4��Д�t�����C\6��ݤ�,�E�T!I�)��xX���v�H��J̝q�kE��Yݎ�<��Ԧ^#߂���=��_䱟*,�b�SF�k!c�k|�:ZfD��m�3���ܼ�%UNo&_�~����$�o*��z')yٝ�����^��h�,U��f�t����|+z^�Et��p<�Z��NB���� R�/�eG�#���d��<aG9��2vY�|>���I��v�wC]L�u��U�Y�ĳ!�By�'��z�/a?iP���^�5�12��	�WSq���r<NLR#��ҵ�7��s�Y۬��A��g~׻�qw4�9&��wn"W�F��{�&mVw��l����9Y��ntG�2UyP��ЕFDݺ�g�C/�C͏�L�m��l��Z4|�
�n=���iM�2f]E���R'�$}����VM8}|Ae�(6ۛ�"p�4�|��>ݮ�|��j�k�~f�.���ѠC!lV���y�V���;/6�O�]��(�Qx���[T���ۖ/1+琥���j��A=�N���~T�b(�oq����������      *   Z  x����n�@ ����h 1�ъ@��^\�Xy�ֶ$m��:3�|�I��|�Q#8�.�m$#q�y
'S=<�#�^��d4�C�$�B-��::a�@��e�!��(Ma�o��үqy��p�u����pd��"}"�����N?�@�Yt�=�l�#QW͡&�2	���-�����7Y���=�)���Q���yL=q�ɫT��w˭�4�4�:���[-����~�*D�WF�$ܫ���Hg�,�X`$`j�?��7�{{�{�YPoni�_��w2-�#���8Ļ�q�g�J�[�c�
]��e?_ԗ��[�ʷ�6Yٞ��ǰ��}��      +   �   x�����0  �3�4�|���`(X�Z��TA�N�t����YƼx�#���Ch8uv�8f����?e�A*�@���vd"���@�E�m]t�#}G�&.4���f�i3���2N������f��$�<݀UM��X<� �	>�E���.9� �R      -      x������ � �      '   �   x�u�Kr�0  �59'`�0����H*q�I�L ���3����S��P!vi.���7��F�PifM۷�YX�O5��|�4ë�g�w��Y�j+Pzܗ�p(�چ%�'q_$٪���Oμ(·����Oh���D�"������E�>��l��G'��Zb����C��}�(��^��xWB�G��4	�w3��^�e>�d�}��o �yV�      0      x������ � �      )   �   x���=��0 �:��0aٰڭ.Έ������$�DdC��ߟ���uﰛ��y̛��+i�<<��S;�N�
Ǩqh�������UQ��|T���D!��CD$|[ � � gc �=�i��G�ܔ��������+�����xǮ-W�4�����H;t��7;��0Yd���`[DSVi+6��&�Z���w������ �W�      (   M  x���Ɏ�@��5<�)(�v���n5njb�,@)��;�ʵ&wu�˟����ջw��;�V��6e�m]��.���rX>��@�*�O#�
e0@3Ll� ��L�CZQ�`S�+��(k����"�@�)��Ϝ�<P�Z�2v�c�3n�P�L<_ӪS�'��I�ީ�8��Y�<���H�D��D��M�(_�t!ۭ�$��,����MieM�j��Mw{�$�AԤB�;�f��E�AØԼſa4�֋@*���"����\kG�H��T�J�a�{qJ�$[��hO����W?��
���,����p�<�TU��2��     