#!/bin/bash
mysql -u root -e "CREATE DATABASE datagrid;"
mysql -u root -e datagrid < /usr/share/datagrid/dummy.sql
