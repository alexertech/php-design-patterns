#!/bin/bash

# Parámetros
# 1 - base de datos
# 2 - tabla
# 3 - nombre capital
# 4 - nombre

FECHA=`date +%d.%m.%y`

# Extraemos los nombres de los campos
CAMPOS=(`echo "\d $2" | psql $1 | grep '|' | awk '{print $1}' | sed '1d'`);

# Copiar archivos

sed "s/#NOMBRE/$4/;s/#NOMBCAP/$3/;s/#FECHA/$FECHA/;s/#TABLA/$2/;s/#CODTABLA/${CAMPOS[0]}/" _DAO_Template > ../../lib/dao/"$3DAO.php"
sed "s/#NOMBRE/$4/;s/#NOMBCAP/$3/;s/#FECHA/$FECHA/" _VO_Template > ../../lib/model/"$3.php"

sed "s/#NOMBRE/$4/;s/#NOMBCAP/$3/;s/#FECHA/$FECHA/;s/#CODTABLA/${CAMPOS[0]}/" _ins_CTL_Template > ../../control/"ctl_$4_ins.php"
sed "s/#NOMBRE/$4/" _ins_Template > ../../"$4_ins.php"

sed "s/#NOMBRE/$4/;s/#NOMBCAP/$3/;s/#FECHA/$FECHA/;s/#CODTABLA/${CAMPOS[0]}/" _mod_CTL_Template > ../../control/"ctl_$4_mod.php"
sed "s/#NOMBRE/$4/;s/#CODTABLA/${CAMPOS[0]}/" _mod_Template > ../../"$4_mod.php"

sed "s/#NOMBRE/$4/;s/#NOMBCAP/$3/;s/#FECHA/$FECHA/;s/#CODTABLA/${CAMPOS[0]}/" _lst_CTL_Template > ../../control/"ctl_$4.php"
sed "s/#NOMBRE/$4/;s/#CODTABLA/${CAMPOS[0]}/" _lst_Template > ../../"$4.php"

# Ajustar Archivos
NCAMPOS=${#CAMPOS[@]}


# VO
TEXTO="var "
for (( i=0;i<$NCAMPOS;i++));
do
    k=$[$i+1]

    SEP=", \n        "
    if [ "$k" == $NCAMPOS ]; then
        SEP=";"
    fi

    TEXTO="$TEXTO\$${CAMPOS[${i}]}$SEP"
done
sed -i "s/#CAMPOS/$TEXTO/" ../../lib/model/"$3.php"

# DAO
TEXTOINTO=""
TEXTOVALUES=""
TEXTOCONSULTAR=""
TEXTOSET=""
for (( i=1;i<$NCAMPOS;i++));
do
    k=$[$i+1]

    SEP=","
    if [ "$k" == $NCAMPOS ]; then
        SEP=""
    fi
    TEXTOINTO="$TEXTOINTO${CAMPOS[${i}]}$SEP"
    TEXTOVALUES="$TEXTOVALUES'\{\$vo->${CAMPOS[${i}]}\}'$SEP"
    TEXTOCONSULTAR="$TEXTOCONSULTAR            \$vo->${CAMPOS[${i}]} = \$row['${CAMPOS[${i}]}'];\n"
    TEXTOSET="$TEXTOSET                    ${CAMPOS[${i}]} = '\{\$vo->${CAMPOS[${i}]}\}'$SEP\n"
done
sed -i "s/#INTO/$TEXTOINTO/;s/#VALUES/$TEXTOVALUES/;s/#CONSULTAR/$TEXTOCONSULTAR/;s/#SET/$TEXTOSET/" ../../lib/dao/"$3DAO.php"
sed -i "s/#CODTABLA/${CAMPOS[0]}/" ../../lib/dao/"$3DAO.php"


# CAMPOS PARA INS Y MOD
TEXTOINS=""
TEXTOMOD=""
for (( i=1;i<$NCAMPOS;i++));
do
    TEXTOINS="$TEXTOINS\\"\
"<tr>\n\\"\
"        <td class=\"sombra1\" style=\"width:25%\"><?=\$obliga?>${CAMPOS[${i}]}<\/td>\n\\"\
"        <td class=\"sombra2\">\n\\"\
"            <input type=\"text\" name=\"${CAMPOS[${i}]}\">\n\\"\
"        <\/td>\n\\"\
"    <\/tr>\n    ";
    TEXTOMOD="$TEXTOMOD\\"\
"<tr>\n\\"\
"        <td class=\"sombra1\" style=\"width:25%\"><?=\$obliga?>${CAMPOS[${i}]}<\/td>\n\\"\
"        <td class=\"sombra2\">\n\\"\
"            <input type=\"text\" name=\"${CAMPOS[${i}]}\"\n\\"\
"                   value=\"<?=\$c->vo->${CAMPOS[${i}]}?>\">\n\\"\
"        <\/td>\n\\"\
"    <\/tr>\n    ";
done
sed -i "s/#CAMPOS/$TEXTOINS/" ../../"$4_ins.php"
sed -i "s/#CAMPOS/$TEXTOMOD/" ../../"$4_mod.php"

TEXTOPOST=""
for (( i=1;i<$NCAMPOS;i++));
do
    k=$[$i+1]

    TEXTOPOST="$TEXTOPOST\$this->vo->${CAMPOS[${i}]} = \$_POST['${CAMPOS[${i}]}'];\n        "
done
sed -i "s/#CAMPOSPOST/$TEXTOPOST/" ../../control/"ctl_$4_ins.php"
sed -i "s/#CAMPOSPOST/$TEXTOPOST/" ../../control/"ctl_$4_mod.php"

# REGISTRO EN LA FABRICA
FACDAO="case '$4' : return new $3DAO(\$db->getConn()); break;\n            #FACTORYDAO"
sed -i "s/#FACTORYDAO/$FACDAO/" ../../lib/common/Factory.php

FACVO="case '$4' : return new $3(); break;\n            #FACTORYVO"
sed -i "s/#FACTORYVO/$FACVO/" ../../lib/common/Factory.php

# REGISTRO EN LAS INCLUSIONES
INC="\/\/ $3 \ninclude_once \'lib\/model\/$3.php\';\ninclude_once \'lib\/dao\/$3DAO.php\';\n\n#INCLUDES"
sed -i "s/#INCLUDES/$INC/" ../../lib/base_inc.php

# REGISTRO DE PERMISO
PER="\$p_$4 = $5;\n#PERMISOS"
sed -i "s/#PERMISOS/$PER/" ../../lib/config_inc.php
