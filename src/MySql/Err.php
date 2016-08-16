<?php namespace QueryBuilder\MySql;

abstract class Err {

    /**
     * hashchk
     *
     * @deprecated Unused.
     */
    const HASHCHK = 1000;

    /**
     * isamchk
     *
     * @deprecated Unused.
     */
    const NISAMCHK = 1001;

    /**
     * NO
     *
     * Used in the construction of other messages.
     */
    const NO = 1002;

    /**
     * YES
     *
     * Used in the construction of other messages.
     *
     * Extended EXPLAIN format generates Note messages. ER_YES is used in the Code column for these messages in subsequent SHOW WARNINGS output.
     */
    const YES = 1003;

    /**
     * Can't create file '%s' (errno: %d - %s)
     *
     * Occurs for failure to copy an .frm file to a new location, during execution of a CREATE TABLE dst LIKE src statement when the server tries to copy the source table .frm file to the destination table .frm file.
     *
     * Possible causes: Permissions problem for source .frm file; destination .frm file already exists but is not writeable.
     */
    const CANT_CREATE_FILE = 1004;

    /**
     * Can't create table '%s' (errno: %d)
     *
     * InnoDB reports this error when a table cannot be created. If the error message refers to error 150, table creation failed because a foreign key constraint was not correctly formed. If the error message refers to error −1, table creation probably failed because the table includes a column name that matched the name of an internal InnoDB table.
     */
    const CANT_CREATE_TABLE = 1005;

    /**
     * Can't create database '%s' (errno: %d)
     */
    const CANT_CREATE_DB = 1006;

    /**
     * Can't create database '%s'; database exists
     *
     * An attempt to create a database failed because the database already exists.
     *
     * Drop the database first if you really want to replace an existing database, or add an IF NOT EXISTS clause to the CREATE DATABASE statement if to retain an existing database without having the statement produce an error.
     */
    const DB_CREATE_EXISTS = 1007;

    /**
     * Can't drop database '%s'; database doesn't exist
     */
    const DB_DROP_EXISTS = 1008;

    /**
     * Error dropping database (can't delete '%s', errno: %d)
     */
    const DB_DROP_DELETE = 1009;

    /**
     * Error dropping database (can't rmdir '%s', errno: %d)
     */
    const DB_DROP_RMDIR = 1010;

    /**
     * Error on delete of '%s' (errno: %d - %s)
     */
    const CANT_DELETE_FILE = 1011;

    /**
     * Can't read record in system table
     *
     * Returned by InnoDB for attempts to access InnoDB INFORMATION_SCHEMA tables when InnoDB is unavailable.
     */
    const CANT_FIND_SYSTEM_REC = 1012;

    /**
     * Can't get status of '%s' (errno: %d - %s)
     */
    const CANT_GET_STAT = 1013;

    /**
     * Can't get working directory (errno: %d - %s)
     */
    const CANT_GET_WD = 1014;

    /**
     * Can't lock file (errno: %d - %s)
     */
    const CANT_LOCK = 1015;

    /**
     * Can't open file: '%s' (errno: %d - %s)
     *
     * InnoDB reports this error when the table from the InnoDB data files cannot be found, even though the .frm file for the table exists. See Section 15.21.3, “Troubleshooting InnoDB Data Dictionary Operations”.
     */
    const CANT_OPEN_FILE = 1016;

    /**
     * Can't find file: '%s' (errno: %d - %s)
     */
    const FILE_NOT_FOUND = 1017;

    /**
     * Can't read dir of '%s' (errno: %d - %s)
     */
    const CANT_READ_DIR = 1018;

    /**
     * Can't change dir to '%s' (errno: %d - %s)
     */
    const CANT_SET_WD = 1019;

    /**
     * Record has changed since last read in table '%s'
     */
    const CHECKREAD = 1020;

    /**
     * Disk full (%s); waiting for someone to free some space... (errno: %d - %s)
     */
    const DISK_FULL = 1021;

    /**
     * Can't write; duplicate key in table '%s'
     */
    const DUP_KEY = 1022;

    /**
     * Error on close of '%s' (errno: %d - %s)
     */
    const ERROR_ON_CLOSE = 1023;

    /**
     * Error reading file '%s' (errno: %d - %s)
     */
    const ERROR_ON_READ = 1024;

    /**
     * Error on rename of '%s' to '%s' (errno: %d - %s)
     */
    const ERROR_ON_RENAME = 1025;

    /**
     * Error writing file '%s' (errno: %d - %s)
     */
    const ERROR_ON_WRITE = 1026;

    /**
     * '%s' is locked against change
     */
    const FILE_USED = 1027;

    /**
     * Sort aborted
     */
    const FILSORT_ABORT = 1028;

    /**
     * View '%s' doesn't exist for '%s'
     */
    const FORM_NOT_FOUND = 1029;

    /**
     * Got error %d from storage engine
     *
     * Check the %d value to see what the OS error means. For example, 28 indicates that you have run out of disk space.
     */
    const GET_ERRNO = 1030;

    /**
     * Table storage engine for '%s' doesn't have this option
     */
    const ILLEGAL_HA = 1031;

    /**
     * Can't find record in '%s'
     */
    const KEY_NOT_FOUND = 1032;

    /**
     * Incorrect information in file: '%s'
     */
    const NOT_FORM_FILE = 1033;

    /**
     * Incorrect key file for table '%s'; try to repair it
     */
    const NOT_KEYFILE = 1034;

    /**
     * Old key file for table '%s'; repair it!
     */
    const OLD_KEYFILE = 1035;

    /**
     * Table '%s' is read only
     */
    const OPEN_AS_READONLY = 1036;

    /**
     * Out of memory; restart server and try again (needed %d bytes)
     */
    const OUTOFMEMORY = 1037;

    /**
     * Out of sort memory, consider increasing server sort buffer size
     */
    const OUT_OF_SORTMEMORY = 1038;

    /**
     * Unexpected EOF found when reading file '%s' (errno: %d - %s)
     */
    const UNEXPECTED_EOF = 1039;

    /**
     * Too many connections
     */
    const CON_COUNT_ERROR = 1040;

    /**
     * Out of memory; check if mysqld or some other process uses all available memory; if not, you may have to use 'ulimit' to allow mysqld to use more memory or you can add more swap space
     */
    const OUT_OF_RESOURCES = 1041;

    /**
     * Can't get hostname for your address
     */
    const BAD_HOST_ERROR = 1042;

    /**
     * Bad handshake
     */
    const HANDSHAKE_ERROR = 1043;

    /**
     * Access denied for user '%s'@'%s' to database '%s'
     */
    const DBACCESS_DENIED_ERROR = 1044;

    /**
     * Access denied for user '%s'@'%s' (using password: %s)
     */
    const ACCESS_DENIED_ERROR = 1045;

    /**
     * No database selected
     */
    const NO_DB_ERROR = 1046;

    /**
     * Unknown command
     */
    const UNKNOWN_COM_ERROR = 1047;

    /**
     * Column '%s' cannot be null
     */
    const BAD_NULL_ERROR = 1048;

    /**
     * Unknown database '%s'
     */
    const BAD_DB_ERROR = 1049;

    /**
     * Table '%s' already exists
     */
    const TABLE_EXISTS_ERROR = 1050;

    /**
     * Unknown table '%s'
     */
    const BAD_TABLE_ERROR = 1051;

    /**
     * Column '%s' in %s is ambiguous
     *
     * %s = column name
     * %s = location of column (for example, "field list")
     * Likely cause: A column appears in a query without appropriate qualification, such as in a select list or ON clause.
     *
     * Examples:
     *
     * mysql> SELECT i FROM t INNER JOIN t AS t2;
     * ERROR 1052 (23000): Column 'i' in field list is ambiguous
     *
     * mysql> SELECT * FROM t LEFT JOIN t AS t2 ON i = i;
     * ERROR 1052 (23000): Column 'i' in on clause is ambiguous
     * Resolution:
     *
     * Qualify the column with the appropriate table name:
     *
     * mysql> SELECT t2.i FROM t INNER JOIN t AS t2;
     * Modify the query to avoid the need for qualification:
     *
     * mysql> SELECT * FROM t LEFT JOIN t AS t2 USING (i);
     */
    const NON_UNIQ_ERROR = 1052;

    /**
     * Server shutdown in progress
     */
    const SERVER_SHUTDOWN = 1053;

    /**
     * Unknown column '%s' in '%s'
     */
    const BAD_FIELD_ERROR = 1054;

    /**
     * '%s' isn't in GROUP BY
     */
    const WRONG_FIELD_WITH_GROUP = 1055;

    /**
     * Can't group on '%s'
     */
    const WRONG_GROUP_FIELD = 1056;

    /**
     * Statement has sum functions and columns in same statement
     */
    const WRONG_SUM_SELECT = 1057;

    /**
     * Column count doesn't match value count
     */
    const WRONG_VALUE_COUNT = 1058;

    /**
     * Identifier name '%s' is too long
     */
    const TOO_LONG_IDENT = 1059;

    /**
     * Duplicate column name '%s'
     */
    const DUP_FIELDNAME = 1060;

    /**
     * Duplicate key name '%s'
     */
    const DUP_KEYNAME = 1061;

    /**
     * Duplicate entry '%s' for key %d
     *
     * The message returned with this error uses the format string for ER_DUP_ENTRY_WITH_KEY_NAME.
     */
    const DUP_ENTRY = 1062;

    /**
     * Incorrect column specifier for column '%s'
     */
    const WRONG_FIELD_SPEC = 1063;

    /**
     * %s near '%s' at line %d
     */
    const PARSE_ERROR = 1064;

    /**
     * Query was empty
     */
    const EMPTY_QUERY = 1065;

    /**
     * Not unique table/alias: '%s'
     */
    const NONUNIQ_TABLE = 1066;

    /**
     * Invalid default value for '%s'
     */
    const INVALID_DEFAULT = 1067;

    /**
     * Multiple primary key defined
     */
    const MULTIPLE_PRI_KEY = 1068;

    /**
     * Too many keys specified; max %d keys allowed
     */
    const TOO_MANY_KEYS = 1069;

    /**
     * Too many key parts specified; max %d parts allowed
     */
    const TOO_MANY_KEY_PARTS = 1070;

    /**
     * Specified key was too long; max key length is %d bytes
     */
    const TOO_LONG_KEY = 1071;

    /**
     * Key column '%s' doesn't exist in table
     */
    const KEY_COLUMN_DOES_NOT_EXITS = 1072;

    /**
     * BLOB column '%s' can't be used in key specification with the used table type
     */
    const BLOB_USED_AS_KEY = 1073;

    /**
     * Column length too big for column '%s' (max = %lu); use BLOB or TEXT instead
     */
    const TOO_BIG_FIELDLENGTH = 1074;

    /**
     * Incorrect table definition; there can be only one auto column and it must be defined as a key
     */
    const WRONG_AUTO_KEY = 1075;

    /**
     * %s: ready for connections. Version: '%s' socket: '%s' port: %d
     */
    const READY = 1076;

    /**
     * %s: Normal shutdown
     */
    const NORMAL_SHUTDOWN = 1077;

    /**
     * %s: Got signal %d. Aborting!
     */
    const GOT_SIGNAL = 1078;

    /**
     * %s: Shutdown complete
     */
    const SHUTDOWN_COMPLETE = 1079;

    /**
     * %s: Forcing close of thread %ld user: '%s'
     */
    const FORCING_CLOSE = 1080;

    /**
     * Can't create IP socket
     */
    const IPSOCK_ERROR = 1081;

    /**
     * Table '%s' has no index like the one used in CREATE INDEX; recreate the table
     */
    const NO_SUCH_INDEX = 1082;

    /**
     * Field separator argument is not what is expected; check the manual
     */
    const WRONG_FIELD_TERMINATORS = 1083;

    /**
     * You can't use fixed rowlength with BLOBs; please use 'fields terminated by'
     */
    const BLOBS_AND_NO_TERMINATED = 1084;

    /**
     * The file '%s' must be in the database directory or be readable by all
     */
    const TEXTFILE_NOT_READABLE = 1085;

    /**
     * File '%s' already exists
     */
    const FILE_EXISTS_ERROR = 1086;

    /**
     * Records: %ld Deleted: %ld Skipped: %ld Warnings: %ld
     */
    const LOAD_INFO = 1087;

    /**
     * Records: %ld Duplicates: %ld
     */
    const ALTER_INFO = 1088;

    /**
     * Incorrect prefix key; the used key part isn't a string, the used length is longer than the key part, or the storage engine doesn't support unique prefix keys
     */
    const WRONG_SUB_KEY = 1089;

    /**
     * You can't delete all columns with ALTER TABLE; use DROP TABLE instead
     */
    const CANT_REMOVE_ALL_FIELDS = 1090;

    /**
     * Can't DROP '%s'; check that column/key exists
     */
    const CANT_DROP_FIELD_OR_KEY = 1091;

    /**
     * Records: %ld Duplicates: %ld Warnings: %ld
     */
    const INSERT_INFO = 1092;

    /**
     * You can't specify target table '%s' for update in FROM clause
     */
    const UPDATE_TABLE_USED = 1093;

    /**
     * Unknown thread id: %lu
     */
    const NO_SUCH_THREAD = 1094;

    /**
     * You are not owner of thread %lu
     */
    const KILL_DENIED_ERROR = 1095;

    /**
     * No tables used
     */
    const NO_TABLES_USED = 1096;

    /**
     * Too many strings for column %s and SET
     */
    const TOO_BIG_SET = 1097;

    /**
     * Can't generate a unique log-filename %s.(1-999)
     */
    const NO_UNIQUE_LOGFILE = 1098;

    /**
     * Table '%s' was locked with a READ lock and can't be updated
     */
    const TABLE_NOT_LOCKED_FOR_WRITE = 1099;

    /**
     * Table '%s' was not locked with LOCK TABLES
     */
    const TABLE_NOT_LOCKED = 1100;

    /**
     * BLOB, TEXT, GEOMETRY or JSON column '%s' can't have a default value
     */
    const BLOB_CANT_HAVE_DEFAULT = 1101;

    /**
     * Incorrect database name '%s'
     */
    const WRONG_DB_NAME = 1102;

    /**
     * Incorrect table name '%s'
     */
    const WRONG_TABLE_NAME = 1103;

    /**
     * The SELECT would examine more than MAX_JOIN_SIZE rows; check your WHERE and use SET SQL_BIG_SELECTS=1 or SET MAX_JOIN_SIZE=# if the SELECT is okay
     */
    const TOO_BIG_SELECT = 1104;

    /**
     * Unknown error
     */
    const UNKNOWN_ERROR = 1105;

    /**
     * Unknown procedure '%s'
     */
    const UNKNOWN_PROCEDURE = 1106;

    /**
     * Incorrect parameter count to procedure '%s'
     */
    const WRONG_PARAMCOUNT_TO_PROCEDURE = 1107;

    /**
     * Incorrect parameters to procedure '%s'
     */
    const WRONG_PARAMETERS_TO_PROCEDURE = 1108;

    /**
     * Unknown table '%s' in %s
     */
    const UNKNOWN_TABLE = 1109;

    /**
     * Column '%s' specified twice
     */
    const FIELD_SPECIFIED_TWICE = 1110;

    /**
     * Invalid use of group function
     */
    const INVALID_GROUP_FUNC_USE = 1111;

    /**
     * Table '%s' uses an extension that doesn't exist in this MySQL version
     */
    const UNSUPPORTED_EXTENSION = 1112;

    /**
     * A table must have at least 1 column
     */
    const TABLE_MUST_HAVE_COLUMNS = 1113;

    /**
     * The table '%s' is full
     *
     * InnoDB reports this error when the system tablespace runs out of free space. Reconfigure the system tablespace to add a new data file.
     */
    const RECORD_FILE_FULL = 1114;

    /**
     * Unknown character set: '%s'
     */
    const UNKNOWN_CHARACTER_SET = 1115;

    /**
     * Too many tables; MySQL can only use %d tables in a join
     */
    const TOO_MANY_TABLES = 1116;

    /**
     * Too many columns
     */
    const TOO_MANY_FIELDS = 1117;

    /**
     * Row size too large. The maximum row size for the used table type, not counting BLOBs, is %ld. This includes storage overhead, check the manual. You have to change some columns to TEXT or BLOBs
     */
    const TOO_BIG_ROWSIZE = 1118;

    /**
     * Thread stack overrun: Used: %ld of a %ld stack. Use 'mysqld --thread_stack=#' to specify a bigger stack if needed
     */
    const STACK_OVERRUN = 1119;

    /**
     * Cross dependency found in OUTER JOIN; examine your ON conditions
     */
    const WRONG_OUTER_JOIN = 1120;

    /**
     * Table handler doesn't support NULL in given index. Please change column '%s' to be NOT NULL or use another handler
     */
    const NULL_COLUMN_IN_INDEX = 1121;

    /**
     * Can't load function '%s'
     */
    const CANT_FIND_UDF = 1122;

    /**
     * Can't initialize function '%s'; %s
     */
    const CANT_INITIALIZE_UDF = 1123;

    /**
     * No paths allowed for shared library
     */
    const UDF_NO_PATHS = 1124;

    /**
     * Function '%s' already exists
     */
    const UDF_EXISTS = 1125;

    /**
     * Can't open shared library '%s' (errno: %d %s)
     */
    const CANT_OPEN_LIBRARY = 1126;

    /**
     * Can't find symbol '%s' in library
     */
    const CANT_FIND_DL_ENTRY = 1127;

    /**
     * Function '%s' is not defined
     */
    const FUNCTION_NOT_DEFINED = 1128;

    /**
     * Host '%s' is blocked because of many connection errors; unblock with 'mysqladmin flush-hosts'
     */
    const HOST_IS_BLOCKED = 1129;

    /**
     * Host '%s' is not allowed to connect to this MySQL server
     */
    const HOST_NOT_PRIVILEGED = 1130;

    /**
     * You are using MySQL as an anonymous user and anonymous users are not allowed to change passwords
     */
    const PASSWORD_ANONYMOUS_USER = 1131;

    /**
     * You must have privileges to update tables in the mysql database to be able to change passwords for others
     */
    const PASSWORD_NOT_ALLOWED = 1132;

    /**
     * Can't find any matching row in the user table
     */
    const PASSWORD_NO_MATCH = 1133;

    /**
     * Rows matched: %ld Changed: %ld Warnings: %ld
     */
    const UPDATE_INFO = 1134;

    /**
     * Can't create a new thread (errno %d); if you are not out of available memory, you can consult the manual for a possible OS-dependent bug
     */
    const CANT_CREATE_THREAD = 1135;

    /**
     * Column count doesn't match value count at row %ld
     */
    const WRONG_VALUE_COUNT_ON_ROW = 1136;

    /**
     * Can't reopen table: '%s'
     */
    const CANT_REOPEN_TABLE = 1137;

    /**
     * Invalid use of NULL value
     */
    const INVALID_USE_OF_NULL = 1138;

    /**
     * Got error '%s' from regexp
     */
    const REGEXP_ERROR = 1139;

    /**
     * Mixing of GROUP columns (MIN(),MAX(),COUNT(),...) with no GROUP columns is illegal if there is no GROUP BY clause
     */
    const MIX_OF_GROUP_FUNC_AND_FIELDS = 1140;

    /**
     * There is no such grant defined for user '%s' on host '%s'
     */
    const NONEXISTING_GRANT = 1141;

    /**
     * %s command denied to user '%s'@'%s' for table '%s'
     */
    const TABLEACCESS_DENIED_ERROR = 1142;

    /**
     * %s command denied to user '%s'@'%s' for column '%s' in table '%s'
     */
    const COLUMNACCESS_DENIED_ERROR = 1143;

    /**
     * Illegal GRANT/REVOKE command; please consult the manual to see which privileges can be used
     */
    const ILLEGAL_GRANT_FOR_TABLE = 1144;

    /**
     * The host or user argument to GRANT is too long
     */
    const GRANT_WRONG_HOST_OR_USER = 1145;

    /**
     * Table '%s.%s' doesn't exist
     */
    const NO_SUCH_TABLE = 1146;

    /**
     * There is no such grant defined for user '%s' on host '%s' on table '%s'
     */
    const NONEXISTING_TABLE_GRANT = 1147;

    /**
     * The used command is not allowed with this MySQL version
     */
    const NOT_ALLOWED_COMMAND = 1148;

    /**
     * You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use
     */
    const SYNTAX_ERROR = 1149;

    /**
     * Delayed insert thread couldn't get requested lock for table %s
     *
     * @deprecated Unused as of 5.7
     */
    const DELAYED_CANT_CHANGE_LOCK = 1150;

    /**
     * Too many delayed threads in use
     *
     * @deprecated Unused as of 5.7
     */
    const TOO_MANY_DELAYED_THREADS = 1151;

    /**
     * Aborted connection %ld to db: '%s' user: '%s' (%s)
     */
    const ABORTING_CONNECTION = 1152;

    /**
     * Got a packet bigger than 'max_allowed_packet' bytes
     */
    const NET_PACKET_TOO_LARGE = 1153;

    /**
     * Got a read error from the connection pipe
     */
    const NET_READ_ERROR_FROM_PIPE = 1154;

    /**
     * Got an error from fcntl()
     */
    const NET_FCNTL_ERROR = 1155;

    /**
     * Got packets out of order
     */
    const NET_PACKETS_OUT_OF_ORDER = 1156;

    /**
     * Couldn't uncompress communication packet
     */
    const NET_UNCOMPRESS_ERROR = 1157;

    /**
     * Got an error reading communication packets
     */
    const NET_READ_ERROR = 1158;

    /**
     * Got timeout reading communication packets
     */
    const NET_READ_INTERRUPTED = 1159;

    /**
     * Got an error writing communication packets
     */
    const NET_ERROR_ON_WRITE = 1160;

    /**
     * Got timeout writing communication packets
     */
    const NET_WRITE_INTERRUPTED = 1161;

    /**
     * Result string is longer than 'max_allowed_packet' bytes
     */
    const TOO_LONG_STRING = 1162;

    /**
     * The used table type doesn't support BLOB/TEXT columns
     */
    const TABLE_CANT_HANDLE_BLOB = 1163;

    /**
     * The used table type doesn't support AUTO_INCREMENT columns
     */
    const TABLE_CANT_HANDLE_AUTO_INCREMENT = 1164;

    /**
     * INSERT DELAYED can't be used with table '%s' because it is locked with LOCK TABLES
     *
     * @deprecated Unused as of 5.7
     */
    const DELAYED_INSERT_TABLE_LOCKED = 1165;

    /**
     * Incorrect column name '%s'
     */
    const WRONG_COLUMN_NAME = 1166;

    /**
     * The used storage engine can't index column '%s'
     */
    const WRONG_KEY_COLUMN = 1167;

    /**
     * Unable to open underlying table which is differently defined or of non-MyISAM type or doesn't exist
     */
    const WRONG_MRG_TABLE = 1168;

    /**
     * Can't write, because of unique constraint, to table '%s'
     */
    const DUP_UNIQUE = 1169;

    /**
     * BLOB/TEXT column '%s' used in key specification without a key length
     */
    const BLOB_KEY_WITHOUT_LENGTH = 1170;

    /**
     * All parts of a PRIMARY KEY must be NOT NULL; if you need NULL in a key, use UNIQUE instead
     */
    const PRIMARY_CANT_HAVE_NULL = 1171;

    /**
     * Result consisted of more than one row
     */
    const TOO_MANY_ROWS = 1172;

    /**
     * This table type requires a primary key
     */
    const REQUIRES_PRIMARY_KEY = 1173;

    /**
     * This version of MySQL is not compiled with RAID support
     */
    const NO_RAID_COMPILED = 1174;

    /**
     * You are using safe update mode and you tried to update a table without a WHERE that uses a KEY column
     */
    const UPDATE_WITHOUT_KEY_IN_SAFE_MODE = 1175;

    /**
     * Key '%s' doesn't exist in table '%s'
     */
    const KEY_DOES_NOT_EXITS = 1176;

    /**
     * Can't open table
     */
    const CHECK_NO_SUCH_TABLE = 1177;

    /**
     * The storage engine for the table doesn't support %s
     */
    const CHECK_NOT_IMPLEMENTED = 1178;

    /**
     * You are not allowed to execute this command in a transaction
     */
    const CANT_DO_THIS_DURING_AN_TRANSACTION = 1179;

    /**
     * Got error %d during COMMIT
     */
    const ERROR_DURING_COMMIT = 1180;

    /**
     * Got error %d during ROLLBACK
     */
    const ERROR_DURING_ROLLBACK = 1181;

    /**
     * Got error %d during FLUSH_LOGS
     */
    const ERROR_DURING_FLUSH_LOGS = 1182;

    /**
     * Got error %d during CHECKPOINT
     */
    const ERROR_DURING_CHECKPOINT = 1183;

    /**
     * Aborted connection %u to db: '%s' user: '%s' host: '%s' (%s)
     */
    const NEW_ABORTING_CONNECTION = 1184;

    /**
     * The storage engine for the table does not support binary table dump
     */
    const DUMP_NOT_IMPLEMENTED = 1185;

    /**
     * Binlog closed, cannot RESET MASTER
     */
    const FLUSH_MASTER_BINLOG_CLOSED = 1186;

    /**
     * Failed rebuilding the index of dumped table '%s'
     */
    const INDEX_REBUILD = 1187;

    /**
     * Error from master: '%s'
     */
    const MASTER = 1188;

    /**
     * Net error reading from master
     */
    const MASTER_NET_READ = 1189;

    /**
     * Net error writing to master
     */
    const MASTER_NET_WRITE = 1190;

    /**
     * Can't find FULLTEXT index matching the column list
     */
    const FT_MATCHING_KEY_NOT_FOUND = 1191;

    /**
     * Can't execute the given command because you have active locked tables or an active transaction
     */
    const LOCK_OR_ACTIVE_TRANSACTION = 1192;

    /**
     * Unknown system variable '%s'
     */
    const UNKNOWN_SYSTEM_VARIABLE = 1193;

    /**
     * Table '%s' is marked as crashed and should be repaired
     */
    const CRASHED_ON_USAGE = 1194;

    /**
     * Table '%s' is marked as crashed and last (automatic?) repair failed
     */
    const CRASHED_ON_REPAIR = 1195;

    /**
     * Some non-transactional changed tables couldn't be rolled back
     */
    const WARNING_NOT_COMPLETE_ROLLBACK = 1196;

    /**
     * Multi-statement transaction required more than 'max_binlog_cache_size' bytes of storage; increase this mysqld variable and try again
     */
    const TRANS_CACHE_FULL = 1197;

    /**
     * This operation cannot be performed with a running slave; run STOP SLAVE first
     */
    const SLAVE_MUST_STOP = 1198;

    /**
     * This operation requires a running slave; configure slave and do START SLAVE
     */
    const SLAVE_NOT_RUNNING = 1199;

    /**
     * The server is not configured as slave; fix in config file or with CHANGE MASTER TO
     */
    const BAD_SLAVE = 1200;

    /**
     * Could not initialize master info structure; more error messages can be found in the MySQL error log
     */
    const MASTER_INFO = 1201;

    /**
     * Could not create slave thread; check system resources
     */
    const SLAVE_THREAD = 1202;

    /**
     * User %s already has more than 'max_user_connections' active connections
     */
    const TOO_MANY_USER_CONNECTIONS = 1203;

    /**
     * You may only use constant expressions with SET
     */
    const SET_CONSTANTS_ONLY = 1204;

    /**
     * Lock wait timeout exceeded; try restarting transaction
     *
     * InnoDB reports this error when lock wait timeout expires. The statement that waited too long was rolled back (not the entire transaction). You can increase the value of the innodb_lock_wait_timeout configuration option if SQL statements should wait longer for other transactions to complete, or decrease it if too many long-running transactions are causing locking problems and reducing concurrency on a busy system.
     */
    const LOCK_WAIT_TIMEOUT = 1205;

    /**
     * The total number of locks exceeds the lock table size
     *
     * InnoDB reports this error when the total number of locks exceeds the amount of memory devoted to managing locks. To avoid this error, increase the value of innodb_buffer_pool_size. Within an individual application, a workaround may be to break a large operation into smaller pieces. For example, if the error occurs for a large INSERT, perform several smaller INSERT operations.
     */
    const LOCK_TABLE_FULL = 1206;

    /**
     * Update locks cannot be acquired during a READ UNCOMMITTED transaction
     */
    const READ_ONLY_TRANSACTION = 1207;

    /**
     * DROP DATABASE not allowed while thread is holding global read lock
     */
    const DROP_DB_WITH_READ_LOCK = 1208;

    /**
     * CREATE DATABASE not allowed while thread is holding global read lock
     */
    const CREATE_DB_WITH_READ_LOCK = 1209;

    /**
     * Incorrect arguments to %s
     */
    const WRONG_ARGUMENTS = 1210;

    /**
     * '%s'@'%s' is not allowed to create new users
     */
    const NO_PERMISSION_TO_CREATE_USER = 1211;

    /**
     * Incorrect table definition; all MERGE tables must be in the same database
     */
    const UNION_TABLES_IN_DIFFERENT_DIR = 1212;

    /**
     * Deadlock found when trying to get lock; try restarting transaction
     *
     * InnoDB reports this error when a transaction encounters a deadlock and is automatically rolled back so that your application can take corrective action. To recover from this error, run all the operations in this transaction again. A deadlock occurs when requests for locks arrive in inconsistent order between transactions. The transaction that was rolled back released all its locks, and the other transaction can now get all the locks it requested. Thus, when you re-run the transaction that was rolled back, it might have to wait for other transactions to complete, but typically the deadlock does not recur. If you encounter frequent deadlocks, make the sequence of locking operations (LOCK TABLES, SELECT ... FOR UPDATE, and so on) consistent between the different transactions or applications that experience the issue. See Section 15.5.5, “Deadlocks in InnoDB” for details.
     */
    const LOCK_DEADLOCK = 1213;

    /**
     * The used table type doesn't support FULLTEXT indexes
     */
    const TABLE_CANT_HANDLE_FT = 1214;

    /**
     * Cannot add foreign key constraint
     */
    const CANNOT_ADD_FOREIGN = 1215;

    /**
     * Cannot add or update a child row: a foreign key constraint fails
     *
     * InnoDB reports this error when you try to add a row but there is no parent row, and a foreign key constraint fails. Add the parent row first.
     */
    const NO_REFERENCED_ROW = 1216;

    /**
     * Cannot delete or update a parent row: a foreign key constraint fails
     *
     * InnoDB reports this error when you try to delete a parent row that has children, and a foreign key constraint fails. Delete the children first.
     */
    const ROW_IS_REFERENCED = 1217;

    /**
     * Error connecting to master: %s
     */
    const CONNECT_TO_MASTER = 1218;

    /**
     * Error running query on master: %s
     */
    const QUERY_ON_MASTER = 1219;

    /**
     * Error when executing command %s: %s
     */
    const ERROR_WHEN_EXECUTING_COMMAND = 1220;

    /**
     * Incorrect usage of %s and %s
     */
    const WRONG_USAGE = 1221;

    /**
     * The used SELECT statements have a different number of columns
     */
    const WRONG_NUMBER_OF_COLUMNS_IN_SELECT = 1222;

    /**
     * Can't execute the query because you have a conflicting read lock
     */
    const CANT_UPDATE_WITH_READLOCK = 1223;

    /**
     * Mixing of transactional and non-transactional tables is disabled
     */
    const MIXING_NOT_ALLOWED = 1224;

    /**
     * Option '%s' used twice in statement
     */
    const DUP_ARGUMENT = 1225;

    /**
     * User '%s' has exceeded the '%s' resource (current value: %ld)
     */
    const USER_LIMIT_REACHED = 1226;

    /**
     * Access denied; you need (at least one of) the %s privilege(s) for this operation
     */
    const SPECIFIC_ACCESS_DENIED_ERROR = 1227;

    /**
     * Variable '%s' is a SESSION variable and can't be used with SET GLOBAL
     */
    const LOCAL_VARIABLE = 1228;

    /**
     * Variable '%s' is a GLOBAL variable and should be set with SET GLOBAL
     */
    const GLOBAL_VARIABLE = 1229;

    /**
     * Variable '%s' doesn't have a default value
     */
    const NO_DEFAULT = 1230;

    /**
     * Variable '%s' can't be set to the value of '%s'
     */
    const WRONG_VALUE_FOR_VAR = 1231;

    /**
     * Incorrect argument type to variable '%s'
     */
    const WRONG_TYPE_FOR_VAR = 1232;

    /**
     * Variable '%s' can only be set, not read
     */
    const VAR_CANT_BE_READ = 1233;

    /**
     * Incorrect usage/placement of '%s'
     */
    const CANT_USE_OPTION_HERE = 1234;

    /**
     * This version of MySQL doesn't yet support '%s'
     */
    const NOT_SUPPORTED_YET = 1235;

    /**
     * Got fatal error %d from master when reading data from binary log: '%s'
     */
    const MASTER_FATAL_ERROR_READING_BINLOG = 1236;

    /**
     * Slave SQL thread ignored the query because of replicate-*-table rules
     */
    const SLAVE_IGNORED_TABLE = 1237;

    /**
     * Variable '%s' is a %s variable
     */
    const INCORRECT_GLOBAL_LOCAL_VAR = 1238;

    /**
     * Incorrect foreign key definition for '%s': %s
     */
    const WRONG_FK_DEF = 1239;

    /**
     * Key reference and table reference don't match
     */
    const KEY_REF_DO_NOT_MATCH_TABLE_REF = 1240;

    /**
     * Operand should contain %d column(s)
     */
    const OPERAND_COLUMNS = 1241;

    /**
     * Subquery returns more than 1 row
     */
    const SUBQUERY_NO_1_ROW = 1242;

    /**
     * Unknown prepared statement handler (%.*s) given to %s
     */
    const UNKNOWN_STMT_HANDLER = 1243;

    /**
     * Help database is corrupt or does not exist
     */
    const CORRUPT_HELP_DB = 1244;

    /**
     * Cyclic reference on subqueries
     */
    const CYCLIC_REFERENCE = 1245;

    /**
     * Converting column '%s' from %s to %s
     */
    const AUTO_CONVERT = 1246;

    /**
     * Reference '%s' not supported (%s)
     */
    const ILLEGAL_REFERENCE = 1247;

    /**
     * Every derived table must have its own alias
     */
    const DERIVED_MUST_HAVE_ALIAS = 1248;

    /**
     * Select %u was reduced during optimization
     */
    const SELECT_REDUCED = 1249;

    /**
     * Table '%s' from one of the SELECTs cannot be used in %s
     */
    const TABLENAME_NOT_ALLOWED_HERE = 1250;

    /**
     * Client does not support authentication protocol requested by server; consider upgrading MySQL client
     */
    const NOT_SUPPORTED_AUTH_MODE = 1251;

    /**
     * All parts of a SPATIAL index must be NOT NULL
     */
    const SPATIAL_CANT_HAVE_NULL = 1252;

    /**
     * COLLATION '%s' is not valid for CHARACTER SET '%s'
     */
    const COLLATION_CHARSET_MISMATCH = 1253;

    /**
     * Slave is already running
     */
    const SLAVE_WAS_RUNNING = 1254;

    /**
     * Slave already has been stopped
     */
    const SLAVE_WAS_NOT_RUNNING = 1255;

    /**
     * Uncompressed data size too large; the maximum size is %d (probably, length of uncompressed data was corrupted)
     */
    const TOO_BIG_FOR_UNCOMPRESS = 1256;

    /**
     * ZLIB: Not enough memory
     */
    const ZLIB_Z_MEM_ERROR = 1257;

    /**
     * ZLIB: Not enough room in the output buffer (probably, length of uncompressed data was corrupted)
     */
    const ZLIB_Z_BUF_ERROR = 1258;

    /**
     * ZLIB: Input data corrupted
     */
    const ZLIB_Z_DATA_ERROR = 1259;

    /**
     * Row %u was cut by GROUP_CONCAT()
     */
    const CUT_VALUE_GROUP_CONCAT = 1260;

    /**
     * Row %ld doesn't contain data for all columns
     */
    const WARN_TOO_FEW_RECORDS = 1261;

    /**
     * Row %ld was truncated; it contained more data than there were input columns
     */
    const WARN_TOO_MANY_RECORDS = 1262;

    /**
     * Column set to default value; NULL supplied to NOT NULL column '%s' at row %ld
     */
    const WARN_NULL_TO_NOTNULL = 1263;

    /**
     * Out of range value for column '%s' at row %ld
     */
    const WARN_DATA_OUT_OF_RANGE = 1264;

    /**
     * Data truncated for column '%s' at row %ld
     */
    const WARN_DATA_TRUNCATED = 1265;

    /**
     * Using storage engine %s for table '%s'
     */
    const WARN_USING_OTHER_HANDLER = 1266;

    /**
     * Illegal mix of collations (%s,%s) and (%s,%s) for operation '%s'
     */
    const CANT_AGGREGATE_2COLLATIONS = 1267;

    /**
     * Cannot drop one or more of the requested users
     */
    const DROP_USER = 1268;

    /**
     * Can't revoke all privileges for one or more of the requested users
     */
    const REVOKE_GRANTS = 1269;

    /**
     * Illegal mix of collations (%s,%s), (%s,%s), (%s,%s) for operation '%s'
     */
    const CANT_AGGREGATE_3COLLATIONS = 1270;

    /**
     * Illegal mix of collations for operation '%s'
     */
    const CANT_AGGREGATE_NCOLLATIONS = 1271;

    /**
     * Variable '%s' is not a variable component (can't be used as XXXX.variable_name)
     */
    const VARIABLE_IS_NOT_STRUCT = 1272;

    /**
     * Unknown collation: '%s'
     */
    const UNKNOWN_COLLATION = 1273;

    /**
     * SSL parameters in CHANGE MASTER are ignored because this MySQL slave was compiled without SSL support; they can be used later if MySQL slave with SSL is started
     */
    const SLAVE_IGNORED_SSL_PARAMS = 1274;

    /**
     * Server is running in --secure-auth mode, but '%s'@'%s' has a password in the old format; please change the password to the new format
     */
    const SERVER_IS_IN_SECURE_AUTH_MODE = 1275;

    /**
     * Field or reference '%s%s%s%s%s' of SELECT #%d was resolved in SELECT #%d
     */
    const WARN_FIELD_RESOLVED = 1276;

    /**
     * Incorrect parameter or combination of parameters for START SLAVE UNTIL
     */
    const BAD_SLAVE_UNTIL_COND = 1277;

    /**
     * It is recommended to use --skip-slave-start when doing step-by-step replication with START SLAVE UNTIL; otherwise, you will get problems if you get an unexpected slave's mysqld restart
     */
    const MISSING_SKIP_SLAVE = 1278;

    /**
     * SQL thread is not to be started so UNTIL options are ignored
     */
    const UNTIL_COND_IGNORED = 1279;

    /**
     * Incorrect index name '%s'
     */
    const WRONG_NAME_FOR_INDEX = 1280;

    /**
     * Incorrect catalog name '%s'
     */
    const WRONG_NAME_FOR_CATALOG = 1281;

    /**
     * Query cache failed to set size %lu; new query cache size is %lu
     */
    const WARN_QC_RESIZE = 1282;

    /**
     * Column '%s' cannot be part of FULLTEXT index
     */
    const BAD_FT_COLUMN = 1283;

    /**
     * Unknown key cache '%s'
     */
    const UNKNOWN_KEY_CACHE = 1284;

    /**
     * MySQL is started in --skip-name-resolve mode; you must restart it without this switch for this grant to work
     */
    const WARN_HOSTNAME_WONT_WORK = 1285;

    /**
     * Unknown storage engine '%s'
     */
    const UNKNOWN_STORAGE_ENGINE = 1286;

    /**
     * '%s' is deprecated and will be removed in a future release. Please use %s instead
     */
    const WARN_DEPRECATED_SYNTAX = 1287;

    /**
     * The target table %s of the %s is not updatable
     */
    const NON_UPDATABLE_TABLE = 1288;

    /**
     * The '%s' feature is disabled; you need MySQL built with '%s' to have it working
     */
    const FEATURE_DISABLED = 1289;

    /**
     * The MySQL server is running with the %s option so it cannot execute this statement
     */
    const OPTION_PREVENTS_STATEMENT = 1290;

    /**
     * Column '%s' has duplicated value '%s' in %s
     */
    const DUPLICATED_VALUE_IN_TYPE = 1291;

    /**
     * Truncated incorrect %s value: '%s'
     */
    const TRUNCATED_WRONG_VALUE = 1292;

    /**
     * Incorrect table definition; there can be only one TIMESTAMP column with CURRENT_TIMESTAMP in DEFAULT or ON UPDATE clause
     */
    const TOO_MUCH_AUTO_TIMESTAMP_COLS = 1293;

    /**
     * Invalid ON UPDATE clause for '%s' column
     */
    const INVALID_ON_UPDATE = 1294;

    /**
     * This command is not supported in the prepared statement protocol yet
     */
    const UNSUPPORTED_PS = 1295;

    /**
     * Got error %d '%s' from %s
     */
    const GET_ERRMSG = 1296;

    /**
     * Got temporary error %d '%s' from %s
     */
    const GET_TEMPORARY_ERRMSG = 1297;

    /**
     * Unknown or incorrect time zone: '%s'
     */
    const UNKNOWN_TIME_ZONE = 1298;

    /**
     * Invalid TIMESTAMP value in column '%s' at row %ld
     */
    const WARN_INVALID_TIMESTAMP = 1299;

    /**
     * Invalid %s character string: '%s'
     */
    const INVALID_CHARACTER_STRING = 1300;

    /**
     * Result of %s() was larger than max_allowed_packet (%ld) - truncated
     */
    const WARN_ALLOWED_PACKET_OVERFLOWED = 1301;

    /**
     * Conflicting declarations: '%s%s' and '%s%s'
     */
    const CONFLICTING_DECLARATIONS = 1302;

    /**
     * Can't create a %s from within another stored routine
     */
    const SP_NO_RECURSIVE_CREATE = 1303;

    /**
     * %s %s already exists
     */
    const SP_ALREADY_EXISTS = 1304;

    /**
     * %s %s does not exist
     */
    const SP_DOES_NOT_EXIST = 1305;

    /**
     * Failed to DROP %s %s
     */
    const SP_DROP_FAILED = 1306;

    /**
     * Failed to CREATE %s %s
     */
    const SP_STORE_FAILED = 1307;

    /**
     * %s with no matching label: %s
     */
    const SP_LILABEL_MISMATCH = 1308;

    /**
     * Redefining label %s
     */
    const SP_LABEL_REDEFINE = 1309;

    /**
     * End-label %s without match
     */
    const SP_LABEL_MISMATCH = 1310;

    /**
     * Referring to uninitialized variable %s
     */
    const SP_UNINIT_VAR = 1311;

    /**
     * PROCEDURE %s can't return a result set in the given context
     */
    const SP_BADSELECT = 1312;

    /**
     * RETURN is only allowed in a FUNCTION
     */
    const SP_BADRETURN = 1313;

    /**
     * %s is not allowed in stored procedures
     */
    const SP_BADSTATEMENT = 1314;

    /**
     * The update log is deprecated and replaced by the binary log; SET SQL_LOG_UPDATE has been ignored.
     */
    const UPDATE_LOG_DEPRECATED_IGNORED = 1315;

    /**
     * The update log is deprecated and replaced by the binary log; SET SQL_LOG_UPDATE has been translated to SET SQL_LOG_BIN.
     */
    const UPDATE_LOG_DEPRECATED_TRANSLATED = 1316;

    /**
     * Query execution was interrupted
     */
    const QUERY_INTERRUPTED = 1317;

    /**
     * Incorrect number of arguments for %s %s; expected %u, got %u
     */
    const SP_WRONG_NO_OF_ARGS = 1318;

    /**
     * Undefined CONDITION: %s
     */
    const SP_COND_MISMATCH = 1319;

    /**
     * No RETURN found in FUNCTION %s
     */
    const SP_NORETURN = 1320;

    /**
     * FUNCTION %s ended without RETURN
     */
    const SP_NORETURNEND = 1321;

    /**
     * Cursor statement must be a SELECT
     */
    const SP_BAD_CURSOR_QUERY = 1322;

    /**
     * Cursor SELECT must not have INTO
     */
    const SP_BAD_CURSOR_SELECT = 1323;

    /**
     * Undefined CURSOR: %s
     */
    const SP_CURSOR_MISMATCH = 1324;

    /**
     * Cursor is already open
     */
    const SP_CURSOR_ALREADY_OPEN = 1325;

    /**
     * Cursor is not open
     */
    const SP_CURSOR_NOT_OPEN = 1326;

    /**
     * Undeclared variable: %s
     */
    const SP_UNDECLARED_VAR = 1327;

    /**
     * Incorrect number of FETCH variables
     */
    const SP_WRONG_NO_OF_FETCH_ARGS = 1328;

    /**
     * No data - zero rows fetched, selected, or processed
     */
    const SP_FETCH_NO_DATA = 1329;

    /**
     * Duplicate parameter: %s
     */
    const SP_DUP_PARAM = 1330;

    /**
     * Duplicate variable: %s
     */
    const SP_DUP_VAR = 1331;

    /**
     * Duplicate condition: %s
     */
    const SP_DUP_COND = 1332;

    /**
     * Duplicate cursor: %s
     */
    const SP_DUP_CURS = 1333;

    /**
     * Failed to ALTER %s %s
     */
    const SP_CANT_ALTER = 1334;

    /**
     * Subquery value not supported
     */
    const SP_SUBSELECT_NYI = 1335;

    /**
     * %s is not allowed in stored function or trigger
     */
    const STMT_NOT_ALLOWED_IN_SF_OR_TRG = 1336;

    /**
     * Variable or condition declaration after cursor or handler declaration
     */
    const SP_VARCOND_AFTER_CURSHNDLR = 1337;

    /**
     * Cursor declaration after handler declaration
     */
    const SP_CURSOR_AFTER_HANDLER = 1338;

    /**
     * Case not found for CASE statement
     */
    const SP_CASE_NOT_FOUND = 1339;

    /**
     * Configuration file '%s' is too big
     */
    const FPARSER_TOO_BIG_FILE = 1340;

    /**
     * Malformed file type header in file '%s'
     */
    const FPARSER_BAD_HEADER = 1341;

    /**
     * Unexpected end of file while parsing comment '%s'
     */
    const FPARSER_EOF_IN_COMMENT = 1342;

    /**
     * Error while parsing parameter '%s' (line: '%s')
     */
    const FPARSER_ERROR_IN_PARAMETER = 1343;

    /**
     * Unexpected end of file while skipping unknown parameter '%s'
     */
    const FPARSER_EOF_IN_UNKNOWN_PARAMETER = 1344;

    /**
     * EXPLAIN/SHOW can not be issued; lacking privileges for underlying table
     */
    const VIEW_NO_EXPLAIN = 1345;

    /**
     * File '%s' has unknown type '%s' in its header
     */
    const FRM_UNKNOWN_TYPE = 1346;

    /**
     * '%s.%s' is not %s
     */
    const WRONG_OBJECT = 1347;

    /**
     * Column '%s' is not updatable
     */
    const NONUPDATEABLE_COLUMN = 1348;

    /**
     * View's SELECT contains a subquery in the FROM clause
     *
     * @deprecated Removed after 5.7.6
     */
    const VIEW_SELECT_DERIVED = 1349;

    /**
     * View's SELECT contains a subquery in the FROM clause
     *
     * @since 5.7.7
     */
    const VIEW_SELECT_DERIVED_UNUSED = 1349;

    /**
     * View's SELECT contains a '%s' clause
     */
    const VIEW_SELECT_CLAUSE = 1350;

    /**
     * View's SELECT contains a variable or parameter
     */
    const VIEW_SELECT_VARIABLE = 1351;

    /**
     * View's SELECT refers to a temporary table '%s'
     */
    const VIEW_SELECT_TMPTABLE = 1352;

    /**
     * View's SELECT and view's field list have different column counts
     */
    const VIEW_WRONG_LIST = 1353;

    /**
     * View merge algorithm can't be used here for now (assumed undefined algorithm)
     */
    const WARN_VIEW_MERGE = 1354;

    /**
     * View being updated does not have complete key of underlying table in it
     */
    const WARN_VIEW_WITHOUT_KEY = 1355;

    /**
     * View '%s.%s' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them
     */
    const VIEW_INVALID = 1356;

    /**
     * Can't drop or alter a %s from within another stored routine
     */
    const SP_NO_DROP_SP = 1357;

    /**
     * GOTO is not allowed in a stored procedure handler
     */
    const SP_GOTO_IN_HNDLR = 1358;

    /**
     * Trigger already exists
     */
    const TRG_ALREADY_EXISTS = 1359;

    /**
     * Trigger does not exist
     */
    const TRG_DOES_NOT_EXIST = 1360;

    /**
     * Trigger's '%s' is view or temporary table
     */
    const TRG_ON_VIEW_OR_TEMP_TABLE = 1361;

    /**
     * Updating of %s row is not allowed in %strigger
     */
    const TRG_CANT_CHANGE_ROW = 1362;

    /**
     * There is no %s row in %s trigger
     */
    const TRG_NO_SUCH_ROW_IN_TRG = 1363;

    /**
     * Field '%s' doesn't have a default value
     */
    const NO_DEFAULT_FOR_FIELD = 1364;

    /**
     * Division by 0
     */
    const DIVISION_BY_ZERO = 1365;

    /**
     * Incorrect %s value: '%s' for column '%s' at row %ld
     */
    const TRUNCATED_WRONG_VALUE_FOR_FIELD = 1366;

    /**
     * Illegal %s '%s' value found during parsing
     */
    const ILLEGAL_VALUE_FOR_TYPE = 1367;

    /**
     * CHECK OPTION on non-updatable view '%s.%s'
     */
    const VIEW_NONUPD_CHECK = 1368;

    /**
     * CHECK OPTION failed '%s.%s'
     */
    const VIEW_CHECK_FAILED = 1369;

    /**
     * %s command denied to user '%s'@'%s' for routine '%s'
     */
    const PROCACCESS_DENIED_ERROR = 1370;

    /**
     * Failed purging old relay logs: %s
     */
    const RELAY_LOG_FAIL = 1371;

    /**
     * Password hash should be a %d-digit hexadecimal number
     */
    const PASSWD_LENGTH = 1372;

    /**
     * Target log not found in binlog index
     */
    const UNKNOWN_TARGET_BINLOG = 1373;

    /**
     * I/O error reading log index file
     */
    const IO_ERR_LOG_INDEX_READ = 1374;

    /**
     * Server configuration does not permit binlog purge
     */
    const BINLOG_PURGE_PROHIBITED = 1375;

    /**
     * Failed on fseek()
     */
    const FSEEK_FAIL = 1376;

    /**
     * Fatal error during log purge
     */
    const BINLOG_PURGE_FATAL_ERR = 1377;

    /**
     * A purgeable log is in use, will not purge
     */
    const LOG_IN_USE = 1378;

    /**
     * Unknown error during log purge
     */
    const LOG_PURGE_UNKNOWN_ERR = 1379;

    /**
     * Failed initializing relay log position: %s
     */
    const RELAY_LOG_INIT = 1380;

    /**
     * You are not using binary logging
     */
    const NO_BINARY_LOGGING = 1381;

    /**
     * The '%s' syntax is reserved for purposes internal to the MySQL server
     */
    const RESERVED_SYNTAX = 1382;

    /**
     * WSAStartup Failed
     */
    const WSAS_FAILED = 1383;

    /**
     * Can't handle procedures with different groups yet
     */
    const DIFF_GROUPS_PROC = 1384;

    /**
     * Select must have a group with this procedure
     */
    const NO_GROUP_FOR_PROC = 1385;

    /**
     * Can't use ORDER clause with this procedure
     */
    const ORDER_WITH_PROC = 1386;

    /**
     * Binary logging and replication forbid changing the global server %s
     */
    const LOGGING_PROHIBIT_CHANGING_OF = 1387;

    /**
     * Can't map file: %s, errno: %d
     */
    const NO_FILE_MAPPING = 1388;

    /**
     * Wrong magic in %s
     */
    const WRONG_MAGIC = 1389;

    /**
     * Prepared statement contains too many placeholders
     */
    const PS_MANY_PARAM = 1390;

    /**
     * Key part '%s' length cannot be 0
     */
    const KEY_PART_0 = 1391;

    /**
     * View text checksum failed
     */
    const VIEW_CHECKSUM = 1392;

    /**
     * Can not modify more than one base table through a join view '%s.%s'
     */
    const VIEW_MULTIUPDATE = 1393;

    /**
     * Can not insert into join view '%s.%s' without fields list
     */
    const VIEW_NO_INSERT_FIELD_LIST = 1394;

    /**
     * Can not delete from join view '%s.%s'
     */
    const VIEW_DELETE_MERGE_VIEW = 1395;

    /**
     * Operation %s failed for %s
     */
    const CANNOT_USER = 1396;

    /**
     * XAER_NOTA: Unknown XID
     */
    const XAER_NOTA = 1397;

    /**
     * XAER_INVAL: Invalid arguments (or unsupported command)
     */
    const XAER_INVAL = 1398;

    /**
     * XAER_RMFAIL: The command cannot be executed when global transaction is in the %s state
     */
    const XAER_RMFAIL = 1399;

    /**
     * XAER_OUTSIDE: Some work is done outside global transaction
     */
    const XAER_OUTSIDE = 1400;

    /**
     * XAER_RMERR: Fatal error occurred in the transaction branch - check your data for consistency
     */
    const XAER_RMERR = 1401;

    /**
     * XA_RBROLLBACK: Transaction branch was rolled back
     */
    const XA_RBROLLBACK = 1402;

    /**
     * There is no such grant defined for user '%s' on host '%s' on routine '%s'
     */
    const NONEXISTING_PROC_GRANT = 1403;

    /**
     * Failed to grant EXECUTE and ALTER ROUTINE privileges
     */
    const PROC_AUTO_GRANT_FAIL = 1404;

    /**
     * Failed to revoke all privileges to dropped routine
     */
    const PROC_AUTO_REVOKE_FAIL = 1405;

    /**
     * Data too long for column '%s' at row %ld
     */
    const DATA_TOO_LONG = 1406;

    /**
     * Bad SQLSTATE: '%s'
     */
    const SP_BAD_SQLSTATE = 1407;

    /**
     * %s: ready for connections. Version: '%s' socket: '%s' port: %d %s
     */
    const STARTUP = 1408;

    /**
     * Can't load value from file with fixed size rows to variable
     */
    const LOAD_FROM_FIXED_SIZE_ROWS_TO_VAR = 1409;

    /**
     * You are not allowed to create a user with GRANT
     */
    const CANT_CREATE_USER_WITH_GRANT = 1410;

    /**
     * Incorrect %s value: '%s' for function %s
     */
    const WRONG_VALUE_FOR_TYPE = 1411;

    /**
     * Table definition has changed, please retry transaction
     */
    const TABLE_DEF_CHANGED = 1412;

    /**
     * Duplicate handler declared in the same block
     */
    const SP_DUP_HANDLER = 1413;

    /**
     * OUT or INOUT argument %d for routine %s is not a variable or NEW pseudo-variable in BEFORE trigger
     */
    const SP_NOT_VAR_ARG = 1414;

    /**
     * Not allowed to return a result set from a %s
     */
    const SP_NO_RETSET = 1415;

    /**
     * Cannot get geometry object from data you send to the GEOMETRY field
     */
    const CANT_CREATE_GEOMETRY_OBJECT = 1416;

    /**
     * A routine failed and has neither NO SQL nor READS SQL DATA in its declaration and binary logging is enabled; if non-transactional tables were updated, the binary log will miss their changes
     */
    const FAILED_ROUTINE_BREAK_BINLOG = 1417;

    /**
     * This function has none of DETERMINISTIC, NO SQL, or READS SQL DATA in its declaration and binary logging is enabled (you *might* want to use the less safe log_bin_trust_function_creators variable)
     */
    const BINLOG_UNSAFE_ROUTINE = 1418;

    /**
     * You do not have the SUPER privilege and binary logging is enabled (you *might* want to use the less safe log_bin_trust_function_creators variable)
     */
    const BINLOG_CREATE_ROUTINE_NEED_SUPER = 1419;

    /**
     * You can't execute a prepared statement which has an open cursor associated with it. Reset the statement to re-execute it.
     */
    const EXEC_STMT_WITH_OPEN_CURSOR = 1420;

    /**
     * The statement (%lu) has no open cursor.
     */
    const STMT_HAS_NO_OPEN_CURSOR = 1421;

    /**
     * Explicit or implicit commit is not allowed in stored function or trigger.
     */
    const COMMIT_NOT_ALLOWED_IN_SF_OR_TRG = 1422;

    /**
     * Field of view '%s.%s' underlying table doesn't have a default value
     */
    const NO_DEFAULT_FOR_VIEW_FIELD = 1423;

    /**
     * Recursive stored functions and triggers are not allowed.
     */
    const SP_NO_RECURSION = 1424;

    /**
     * Too big scale %d specified for column '%s'. Maximum is %lu.
     */
    const TOO_BIG_SCALE = 1425;

    /**
     * Too-big precision %d specified for '%s'. Maximum is %lu.
     */
    const TOO_BIG_PRECISION = 1426;

    /**
     * For float(M,D), double(M,D) or decimal(M,D), M must be >= D (column '%s').
     */
    const M_BIGGER_THAN_D = 1427;

    /**
     * You can't combine write-locking of system tables with other tables or lock types
     */
    const WRONG_LOCK_OF_SYSTEM_TABLE = 1428;

    /**
     * Unable to connect to foreign data source: %s
     */
    const CONNECT_TO_FOREIGN_DATA_SOURCE = 1429;

    /**
     * There was a problem processing the query on the foreign data source. Data source error: %s
     */
    const QUERY_ON_FOREIGN_DATA_SOURCE = 1430;

    /**
     * The foreign data source you are trying to reference does not exist. Data source error: %s
     */
    const FOREIGN_DATA_SOURCE_DOESNT_EXIST = 1431;

    /**
     * Can't create federated table. The data source connection string '%s' is not in the correct format
     */
    const FOREIGN_DATA_STRING_INVALID_CANT_CREATE = 1432;

    /**
     * The data source connection string '%s' is not in the correct format
     */
    const FOREIGN_DATA_STRING_INVALID = 1433;

    /**
     * Can't create federated table. Foreign data src error: %s
     */
    const CANT_CREATE_FEDERATED_TABLE = 1434;

    /**
     * Trigger in wrong schema
     */
    const TRG_IN_WRONG_SCHEMA = 1435;

    /**
     * Thread stack overrun: %ld bytes used of a %ld byte stack, and %ld bytes needed. Use 'mysqld --thread_stack=#' to specify a bigger stack.
     */
    const STACK_OVERRUN_NEED_MORE = 1436;

    /**
     * Routine body for '%s' is too long
     */
    const TOO_LONG_BODY = 1437;

    /**
     * Cannot drop default keycache
     */
    const WARN_CANT_DROP_DEFAULT_KEYCACHE = 1438;

    /**
     * Display width out of range for column '%s' (max = %lu)
     */
    const TOO_BIG_DISPLAYWIDTH = 1439;

    /**
     * XAER_DUPID: The XID already exists
     */
    const XAER_DUPID = 1440;

    /**
     * Datetime function: %s field overflow
     */
    const DATETIME_FUNCTION_OVERFLOW = 1441;

    /**
     * Can't update table '%s' in stored function/trigger because it is already used by statement which invoked this stored function/trigger.
     */
    const CANT_UPDATE_USED_TABLE_IN_SF_OR_TRG = 1442;

    /**
     * The definition of table '%s' prevents operation %s on table '%s'.
     */
    const VIEW_PREVENT_UPDATE = 1443;

    /**
     * The prepared statement contains a stored routine call that refers to that same statement. It's not allowed to execute a prepared statement in such a recursive manner
     */
    const PS_NO_RECURSION = 1444;

    /**
     * Not allowed to set autocommit from a stored function or trigger
     */
    const SP_CANT_SET_AUTOCOMMIT = 1445;

    /**
     * Definer is not fully qualified
     */
    const MALFORMED_DEFINER = 1446;

    /**
     * View '%s'.'%s' has no definer information (old table format). Current user is used as definer. Please recreate the view!
     */
    const VIEW_FRM_NO_USER = 1447;

    /**
     * You need the SUPER privilege for creation view with '%s'@'%s' definer
     */
    const VIEW_OTHER_USER = 1448;

    /**
     * The user specified as a definer ('%s'@'%s') does not exist
     */
    const NO_SUCH_USER = 1449;

    /**
     * Changing schema from '%s' to '%s' is not allowed.
     */
    const FORBID_SCHEMA_CHANGE = 1450;

    /**
     * Cannot delete or update a parent row: a foreign key constraint fails (%s)
     */
    const ROW_IS_REFERENCED_2 = 1451;

    /**
     * Cannot add or update a child row: a foreign key constraint fails (%s)
     */
    const NO_REFERENCED_ROW_2 = 1452;

    /**
     * Variable '%s' must be quoted with `...`, or renamed
     */
    const SP_BAD_VAR_SHADOW = 1453;

    /**
     * No definer attribute for trigger '%s'.'%s'. The trigger will be activated under the authorization of the invoker, which may have insufficient privileges. Please recreate the trigger.
     */
    const TRG_NO_DEFINER = 1454;

    /**
     * '%s' has an old format, you should re-create the '%s' object(s)
     */
    const OLD_FILE_FORMAT = 1455;

    /**
     * Recursive limit %d (as set by the max_sp_recursion_depth variable) was exceeded for routine %s
     */
    const SP_RECURSION_LIMIT = 1456;

    /**
     * Failed to load routine %s. The table mysql.proc is missing, corrupt, or contains bad data (internal code %d)
     */
    const SP_PROC_TABLE_CORRUPT = 1457;

    /**
     * Incorrect routine name '%s'
     */
    const SP_WRONG_NAME = 1458;

    /**
     * Table upgrade required. Please do "REPAIR TABLE `%s`" or dump/reload to fix it!
     */
    const TABLE_NEEDS_UPGRADE = 1459;

    /**
     * AGGREGATE is not supported for stored functions
     */
    const SP_NO_AGGREGATE = 1460;

    /**
     * Can't create more than max_prepared_stmt_count statements (current value: %lu)
     */
    const MAX_PREPARED_STMT_COUNT_REACHED = 1461;

    /**
     * `%s`.`%s` contains view recursion
     */
    const VIEW_RECURSIVE = 1462;

    /**
     * Non-grouping field '%s' is used in %s clause
     */
    const NON_GROUPING_FIELD_USED = 1463;

    /**
     * The used table type doesn't support SPATIAL indexes
     */
    const TABLE_CANT_HANDLE_SPKEYS = 1464;

    /**
     * Triggers can not be created on system tables
     */
    const NO_TRIGGERS_ON_SYSTEM_SCHEMA = 1465;

    /**
     * Leading spaces are removed from name '%s'
     */
    const REMOVED_SPACES = 1466;

    /**
     * Failed to read auto-increment value from storage engine
     */
    const AUTOINC_READ_FAILED = 1467;

    /**
     * user name
     */
    const USERNAME = 1468;

    /**
     * host name
     */
    const HOSTNAME = 1469;

    /**
     * String '%s' is too long for %s (should be no longer than %d)
     */
    const WRONG_STRING_LENGTH = 1470;

    /**
     * The target table %s of the %s is not insertable-into
     */
    const NON_INSERTABLE_TABLE = 1471;

    /**
     * Table '%s' is differently defined or of non-MyISAM type or doesn't exist
     */
    const ADMIN_WRONG_MRG_TABLE = 1472;

    /**
     * Too high level of nesting for select
     */
    const TOO_HIGH_LEVEL_OF_NESTING_FOR_SELECT = 1473;

    /**
     * Name '%s' has become ''
     */
    const NAME_BECOMES_EMPTY = 1474;

    /**
     * First character of the FIELDS TERMINATED string is ambiguous; please use non-optional and non-empty FIELDS ENCLOSED BY
     */
    const AMBIGUOUS_FIELD_TERM = 1475;

    /**
     * The foreign server, %s, you are trying to create already exists.
     */
    const FOREIGN_SERVER_EXISTS = 1476;

    /**
     * The foreign server name you are trying to reference does not exist. Data source error: %s
     */
    const FOREIGN_SERVER_DOESNT_EXIST = 1477;

    /**
     * Table storage engine '%s' does not support the create option '%s'
     */
    const ILLEGAL_HA_CREATE_OPTION = 1478;

    /**
     * Syntax error: %s PARTITIONING requires definition of VALUES %s for each partition
     */
    const PARTITION_REQUIRES_VALUES_ERROR = 1479;

    /**
     * Only %s PARTITIONING can use VALUES %s in partition definition
     */
    const PARTITION_WRONG_VALUES_ERROR = 1480;

    /**
     * MAXVALUE can only be used in last partition definition
     */
    const PARTITION_MAXVALUE_ERROR = 1481;

    /**
     * Subpartitions can only be hash partitions and by key
     */
    const PARTITION_SUBPARTITION_ERROR = 1482;

    /**
     * Must define subpartitions on all partitions if on one partition
     */
    const PARTITION_SUBPART_MIX_ERROR = 1483;

    /**
     * Wrong number of partitions defined, mismatch with previous setting
     */
    const PARTITION_WRONG_NO_PART_ERROR = 1484;

    /**
     * Wrong number of subpartitions defined, mismatch with previous setting
     */
    const PARTITION_WRONG_NO_SUBPART_ERROR = 1485;

    /**
     * Constant, random or timezone-dependent expressions in (sub)partitioning function are not allowed
     */
    const WRONG_EXPR_IN_PARTITION_FUNC_ERROR = 1486;

    /**
     * Expression in RANGE/LIST VALUES must be constant
     */
    const NO_CONST_EXPR_IN_RANGE_OR_LIST_ERROR = 1487;

    /**
     * Field in list of fields for partition function not found in table
     */
    const FIELD_NOT_FOUND_PART_ERROR = 1488;

    /**
     * List of fields is only allowed in KEY partitions
     */
    const LIST_OF_FIELDS_ONLY_IN_HASH_ERROR = 1489;

    /**
     * The partition info in the frm file is not consistent with what can be written into the frm file
     */
    const INCONSISTENT_PARTITION_INFO_ERROR = 1490;

    /**
     * The %s function returns the wrong type
     */
    const PARTITION_FUNC_NOT_ALLOWED_ERROR = 1491;

    /**
     * For %s partitions each partition must be defined
     */
    const PARTITIONS_MUST_BE_DEFINED_ERROR = 1492;

    /**
     * VALUES LESS THAN value must be strictly increasing for each partition
     */
    const RANGE_NOT_INCREASING_ERROR = 1493;

    /**
     * VALUES value must be of same type as partition function
     */
    const INCONSISTENT_TYPE_OF_FUNCTIONS_ERROR = 1494;

    /**
     * Multiple definition of same constant in list partitioning
     */
    const MULTIPLE_DEF_CONST_IN_LIST_PART_ERROR = 1495;

    /**
     * Partitioning can not be used stand-alone in query
     */
    const PARTITION_ENTRY_ERROR = 1496;

    /**
     * The mix of handlers in the partitions is not allowed in this version of MySQL
     */
    const MIX_HANDLER_ERROR = 1497;

    /**
     * For the partitioned engine it is necessary to define all %s
     */
    const PARTITION_NOT_DEFINED_ERROR = 1498;

    /**
     * Too many partitions (including subpartitions) were defined
     */
    const TOO_MANY_PARTITIONS_ERROR = 1499;

    /**
     * It is only possible to mix RANGE/LIST partitioning with HASH/KEY partitioning for subpartitioning
     */
    const SUBPARTITION_ERROR = 1500;

    /**
     * Failed to create specific handler file
     */
    const CANT_CREATE_HANDLER_FILE = 1501;

    /**
     * A BLOB field is not allowed in partition function
     */
    const BLOB_FIELD_IN_PART_FUNC_ERROR = 1502;

    /**
     * A %s must include all columns in the table's partitioning function
     */
    const UNIQUE_KEY_NEED_ALL_FIELDS_IN_PF = 1503;

    /**
     * Number of %s = 0 is not an allowed value
     */
    const NO_PARTS_ERROR = 1504;

    /**
     * Partition management on a not partitioned table is not possible
     */
    const PARTITION_MGMT_ON_NONPARTITIONED = 1505;

    /**
     * Foreign keys are not yet supported in conjunction with partitioning
     */
    const FOREIGN_KEY_ON_PARTITIONED = 1506;

    /**
     * Error in list of partitions to %s
     */
    const DROP_PARTITION_NON_EXISTENT = 1507;

    /**
     * Cannot remove all partitions, use DROP TABLE instead
     */
    const DROP_LAST_PARTITION = 1508;

    /**
     * COALESCE PARTITION can only be used on HASH/KEY partitions
     */
    const COALESCE_ONLY_ON_HASH_PARTITION = 1509;

    /**
     * REORGANIZE PARTITION can only be used to reorganize partitions not to change their numbers
     */
    const REORG_HASH_ONLY_ON_SAME_NO = 1510;

    /**
     * REORGANIZE PARTITION without parameters can only be used on auto-partitioned tables using HASH PARTITIONs
     */
    const REORG_NO_PARAM_ERROR = 1511;

    /**
     * %s PARTITION can only be used on RANGE/LIST partitions
     */
    const ONLY_ON_RANGE_LIST_PARTITION = 1512;

    /**
     * Trying to Add partition(s) with wrong number of subpartitions
     */
    const ADD_PARTITION_SUBPART_ERROR = 1513;

    /**
     * At least one partition must be added
     */
    const ADD_PARTITION_NO_NEW_PARTITION = 1514;

    /**
     * At least one partition must be coalesced
     */
    const COALESCE_PARTITION_NO_PARTITION = 1515;

    /**
     * More partitions to reorganize than there are partitions
     */
    const REORG_PARTITION_NOT_EXIST = 1516;

    /**
     * Duplicate partition name %s
     */
    const SAME_NAME_PARTITION = 1517;

    /**
     * It is not allowed to shut off binlog on this command
     */
    const NO_BINLOG_ERROR = 1518;

    /**
     * When reorganizing a set of partitions they must be in consecutive order
     */
    const CONSECUTIVE_REORG_PARTITIONS = 1519;

    /**
     * Reorganize of range partitions cannot change total ranges except for last partition where it can extend the range
     */
    const REORG_OUTSIDE_RANGE = 1520;

    /**
     * Partition function not supported in this version for this handler
     */
    const PARTITION_FUNCTION_FAILURE = 1521;

    /**
     * Partition state cannot be defined from CREATE/ALTER TABLE
     */
    const PART_STATE_ERROR = 1522;

    /**
     * The %s handler only supports 32 bit integers in VALUES
     */
    const LIMITED_PART_RANGE = 1523;

    /**
     * Plugin '%s' is not loaded
     */
    const PLUGIN_IS_NOT_LOADED = 1524;

    /**
     * Incorrect %s value: '%s'
     */
    const WRONG_VALUE = 1525;

    /**
     * Table has no partition for value %s
     */
    const NO_PARTITION_FOR_GIVEN_VALUE = 1526;

    /**
     * It is not allowed to specify %s more than once
     */
    const FILEGROUP_OPTION_ONLY_ONCE = 1527;

    /**
     * Failed to create %s
     */
    const CREATE_FILEGROUP_FAILED = 1528;

    /**
     * Failed to drop %s
     */
    const DROP_FILEGROUP_FAILED = 1529;

    /**
     * The handler doesn't support autoextend of tablespaces
     */
    const TABLESPACE_AUTO_EXTEND_ERROR = 1530;

    /**
     * A size parameter was incorrectly specified, either number or on the form 10M
     */
    const WRONG_SIZE_NUMBER = 1531;

    /**
     * The size number was correct but we don't allow the digit part to be more than 2 billion
     */
    const SIZE_OVERFLOW_ERROR = 1532;

    /**
     * Failed to alter: %s
     */
    const ALTER_FILEGROUP_FAILED = 1533;

    /**
     * Writing one row to the row-based binary log failed
     */
    const BINLOG_ROW_LOGGING_FAILED = 1534;

    /**
     * Table definition on master and slave does not match: %s
     */
    const BINLOG_ROW_WRONG_TABLE_DEF = 1535;

    /**
     * Slave running with --log-slave-updates must use row-based binary logging to be able to replicate row-based binary log events
     */
    const BINLOG_ROW_RBR_TO_SBR = 1536;

    /**
     * Event '%s' already exists
     */
    const EVENT_ALREADY_EXISTS = 1537;

    /**
     * Failed to store event %s. Error code %d from storage engine.
     */
    const EVENT_STORE_FAILED = 1538;

    /**
     * Unknown event '%s'
     */
    const EVENT_DOES_NOT_EXIST = 1539;

    /**
     * Failed to alter event '%s'
     */
    const EVENT_CANT_ALTER = 1540;

    /**
     * Failed to drop %s
     */
    const EVENT_DROP_FAILED = 1541;

    /**
     * INTERVAL is either not positive or too big
     */
    const EVENT_INTERVAL_NOT_POSITIVE_OR_TOO_BIG = 1542;

    /**
     * ENDS is either invalid or before STARTS
     */
    const EVENT_ENDS_BEFORE_STARTS = 1543;

    /**
     * Event execution time is in the past. Event has been disabled
     */
    const EVENT_EXEC_TIME_IN_THE_PAST = 1544;

    /**
     * Failed to open mysql.event
     */
    const EVENT_OPEN_TABLE_FAILED = 1545;

    /**
     * No datetime expression provided
     */
    const EVENT_NEITHER_M_EXPR_NOR_M_AT = 1546;

    /**
     * Column count of mysql.%s is wrong. Expected %d, found %d. The table is probably corrupted
     */
    const OBSOLETE_COL_COUNT_DOESNT_MATCH_CORRUPTED = 1547;

    /**
     * Cannot load from mysql.%s. The table is probably corrupted
     */
    const OBSOLETE_CANNOT_LOAD_FROM_TABLE = 1548;

    /**
     * Failed to delete the event from mysql.event
     */
    const EVENT_CANNOT_DELETE = 1549;

    /**
     * Error during compilation of event's body
     */
    const EVENT_COMPILE_ERROR = 1550;

    /**
     * Same old and new event name
     */
    const EVENT_SAME_NAME = 1551;

    /**
     * Data for column '%s' too long
     */
    const EVENT_DATA_TOO_LONG = 1552;

    /**
     * Cannot drop index '%s': needed in a foreign key constraint
     *
     * InnoDB reports this error when you attempt to drop the last index that can enforce a particular referential constraint.
     *
     * For optimal performance with DML statements, InnoDB requires an index to exist on foreign key columns, so that UPDATE and DELETE operations on a parent table can easily check whether corresponding rows exist in the child table. MySQL creates or drops such indexes automatically when needed, as a side-effect of CREATE TABLE, CREATE INDEX, and ALTER TABLE statements.
     *
     * When you drop an index, InnoDB checks if the index is used for checking a foreign key constraint. It is still OK to drop the index if there is another index that can be used to enforce the same constraint. InnoDB prevents you from dropping the last index that can enforce a particular referential constraint.
     */
    const DROP_INDEX_FK = 1553;

    /**
     * The syntax '%s' is deprecated and will be removed in MySQL %s. Please use %s instead
     */
    const WARN_DEPRECATED_SYNTAX_WITH_VER = 1554;

    /**
     * You can't write-lock a log table. Only read access is possible
     */
    const CANT_WRITE_LOCK_LOG_TABLE = 1555;

    /**
     * You can't use locks with log tables.
     */
    const CANT_LOCK_LOG_TABLE = 1556;

    /**
     * Upholding foreign key constraints for table '%s', entry '%s', key %d would lead to a duplicate entry
     */
    const FOREIGN_DUPLICATE_KEY_OLD_UNUSED = 1557;

    /**
     * Column count of mysql.%s is wrong. Expected %d, found %d. Created with MySQL %d, now running %d. Please use mysql_upgrade to fix this error.
     */
    const COL_COUNT_DOESNT_MATCH_PLEASE_UPDATE = 1558;

    /**
     * Cannot switch out of the row-based binary log format when the session has open temporary tables
     */
    const TEMP_TABLE_PREVENTS_SWITCH_OUT_OF_RBR = 1559;

    /**
     * Cannot change the binary logging format inside a stored function or trigger
     */
    const STORED_FUNCTION_PREVENTS_SWITCH_BINLOG_FORMAT = 1560;

    /**
     * The NDB cluster engine does not support changing the binlog format on the fly yet
     */
    const NDB_CANT_SWITCH_BINLOG_FORMAT = 1561;

    /**
     * Cannot create temporary table with partitions
     */
    const PARTITION_NO_TEMPORARY = 1562;

    /**
     * Partition constant is out of partition function domain
     */
    const PARTITION_CONST_DOMAIN_ERROR = 1563;

    /**
     * This partition function is not allowed
     */
    const PARTITION_FUNCTION_IS_NOT_ALLOWED = 1564;

    /**
     * Error in DDL log
     */
    const DDL_LOG_ERROR = 1565;

    /**
     * Not allowed to use NULL value in VALUES LESS THAN
     */
    const NULL_IN_VALUES_LESS_THAN = 1566;

    /**
     * Incorrect partition name
     */
    const WRONG_PARTITION_NAME = 1567;

    /**
     * Transaction characteristics can't be changed while a transaction is in progress
     */
    const CANT_CHANGE_TX_CHARACTERISTICS = 1568;

    /**
     * ALTER TABLE causes auto_increment resequencing, resulting in duplicate entry '%s' for key '%s'
     */
    const DUP_ENTRY_AUTOINCREMENT_CASE = 1569;

    /**
     * Internal scheduler error %d
     */
    const EVENT_MODIFY_QUEUE_ERROR = 1570;

    /**
     * Error during starting/stopping of the scheduler. Error code %u
     */
    const EVENT_SET_VAR_ERROR = 1571;

    /**
     * Engine cannot be used in partitioned tables
     */
    const PARTITION_MERGE_ERROR = 1572;

    /**
     * Cannot activate '%s' log
     */
    const CANT_ACTIVATE_LOG = 1573;

    /**
     * The server was not built with row-based replication
     */
    const RBR_NOT_AVAILABLE = 1574;

    /**
     * Decoding of base64 string failed
     */
    const BASE64_DECODE_ERROR = 1575;

    /**
     * Recursion of EVENT DDL statements is forbidden when body is present
     */
    const EVENT_RECURSION_FORBIDDEN = 1576;

    /**
     * Cannot proceed because system tables used by Event Scheduler were found damaged at server start
     *
     * To address this issue, try running mysql_upgrade.
     */
    const EVENTS_DB_ERROR = 1577;

    /**
     * Only integers allowed as number here
     */
    const ONLY_INTEGERS_ALLOWED = 1578;

    /**
     * This storage engine cannot be used for log tables"
     */
    const UNSUPORTED_LOG_ENGINE = 1579;

    /**
     * You cannot '%s' a log table if logging is enabled
     */
    const BAD_LOG_STATEMENT = 1580;

    /**
     * Cannot rename '%s'. When logging enabled, rename to/from log table must rename two tables: the log table to an archive table and another table back to '%s'
     */
    const CANT_RENAME_LOG_TABLE = 1581;

    /**
     * Incorrect parameter count in the call to native function '%s'
     */
    const WRONG_PARAMCOUNT_TO_NATIVE_FCT = 1582;

    /**
     * Incorrect parameters in the call to native function '%s'
     */
    const WRONG_PARAMETERS_TO_NATIVE_FCT = 1583;

    /**
     * Incorrect parameters in the call to stored function %s
     */
    const WRONG_PARAMETERS_TO_STORED_FCT = 1584;

    /**
     * This function '%s' has the same name as a native function
     */
    const NATIVE_FCT_NAME_COLLISION = 1585;

    /**
     * Duplicate entry '%s' for key '%s'
     *
     * The format string for this error is also used with ER_DUP_ENTRY.
     */
    const DUP_ENTRY_WITH_KEY_NAME = 1586;

    /**
     * Too many files opened, please execute the command again
     */
    const BINLOG_PURGE_EMFILE = 1587;

    /**
     * Event execution time is in the past and ON COMPLETION NOT PRESERVE is set. The event was dropped immediately after creation.
     */
    const EVENT_CANNOT_CREATE_IN_THE_PAST = 1588;

    /**
     * Event execution time is in the past and ON COMPLETION NOT PRESERVE is set. The event was not changed. Specify a time in the future.
     */
    const EVENT_CANNOT_ALTER_IN_THE_PAST = 1589;

    /**
     * The incident %s occured on the master. Message: %s
     */
    const SLAVE_INCIDENT = 1590;

    /**
     * Table has no partition for some existing values
     */
    const NO_PARTITION_FOR_GIVEN_VALUE_SILENT = 1591;

    /**
     * Unsafe statement written to the binary log using statement format since BINLOG_FORMAT = STATEMENT. %s
     */
    const BINLOG_UNSAFE_STATEMENT = 1592;

    /**
     * Fatal error: %s
     */
    const SLAVE_FATAL_ERROR = 1593;

    /**
     * Relay log read failure: %s
     */
    const SLAVE_RELAY_LOG_READ_FAILURE = 1594;

    /**
     * Relay log write failure: %s
     */
    const SLAVE_RELAY_LOG_WRITE_FAILURE = 1595;

    /**
     * Failed to create %s
     */
    const SLAVE_CREATE_EVENT_FAILURE = 1596;

    /**
     * Master command %s failed: %s
     */
    const SLAVE_MASTER_COM_FAILURE = 1597;

    /**
     * Binary logging not possible. Message: %s
     */
    const BINLOG_LOGGING_IMPOSSIBLE = 1598;

    /**
     * View `%s`.`%s` has no creation context
     */
    const VIEW_NO_CREATION_CTX = 1599;

    /**
     * Creation context of view `%s`.`%s' is invalid
     */
    const VIEW_INVALID_CREATION_CTX = 1600;

    /**
     * Creation context of stored routine `%s`.`%s` is invalid
     */
    const SR_INVALID_CREATION_CTX = 1601;

    /**
     * Corrupted TRG file for table `%s`.`%s`
     */
    const TRG_CORRUPTED_FILE = 1602;

    /**
     * Triggers for table `%s`.`%s` have no creation context
     */
    const TRG_NO_CREATION_CTX = 1603;

    /**
     * Trigger creation context of table `%s`.`%s` is invalid
     */
    const TRG_INVALID_CREATION_CTX = 1604;

    /**
     * Creation context of event `%s`.`%s` is invalid
     */
    const EVENT_INVALID_CREATION_CTX = 1605;

    /**
     * Cannot open table for trigger `%s`.`%s`
     */
    const TRG_CANT_OPEN_TABLE = 1606;

    /**
     * Cannot create stored routine `%s`. Check warnings
     */
    const CANT_CREATE_SROUTINE = 1607;

    /**
     * Ambiguous slave modes combination. %s
     */
    const NEVER_USED = 1608;

    /**
     * The BINLOG statement of type `%s` was not preceded by a format description BINLOG statement.
     */
    const NO_FORMAT_DESCRIPTION_EVENT_BEFORE_BINLOG_STATEMENT = 1609;

    /**
     * Corrupted replication event was detected
     */
    const SLAVE_CORRUPT_EVENT = 1610;

    /**
     * Invalid column reference (%s) in LOAD DATA
     *
     * @deprecated Removed after 5.7.7
     */
    const LOAD_DATA_INVALID_COLUMN = 1611;

    /**
     * Invalid column reference (%s) in LOAD DATA
     *
     * @since 5.7.8
     */
    const LOAD_DATA_INVALID_COLUMN_UNUSED = 1611;

    /**
     * Being purged log %s was not found
     */
    const LOG_PURGE_NO_FILE = 1612;

    /**
     * XA_RBTIMEOUT: Transaction branch was rolled back: took too long
     */
    const XA_RBTIMEOUT = 1613;

    /**
     * XA_RBDEADLOCK: Transaction branch was rolled back: deadlock was detected
     */
    const XA_RBDEADLOCK = 1614;

    /**
     * Prepared statement needs to be re-prepared
     */
    const NEED_REPREPARE = 1615;

    /**
     * DELAYED option not supported for table '%s'
     */
    const DELAYED_NOT_SUPPORTED = 1616;

    /**
     * The master info structure does not exist
     */
    const WARN_NO_MASTER_INFO = 1617;

    /**
     * <%s> option ignored
     */
    const WARN_OPTION_IGNORED = 1618;

    /**
     * Built-in plugins cannot be deleted
     *
     * @deprecated Removed after 5.7.4
     */
    const WARN_PLUGIN_DELETE_BUILTIN = 1619;

    /**
     * Built-in plugins cannot be deleted
     *
     * @since 5.7.5
     */
    const PLUGIN_DELETE_BUILTIN = 1619;

    /**
     * Plugin is busy and will be uninstalled on shutdown
     */
    const WARN_PLUGIN_BUSY = 1620;

    /**
     * %s variable '%s' is read-only. Use SET %s to assign the value
     */
    const VARIABLE_IS_READONLY = 1621;

    /**
     * Storage engine %s does not support rollback for this statement. Transaction rolled back and must be restarted
     */
    const WARN_ENGINE_TRANSACTION_ROLLBACK = 1622;

    /**
     * Unexpected master's heartbeat data: %s
     */
    const SLAVE_HEARTBEAT_FAILURE = 1623;

    /**
     * The requested value for the heartbeat period is either negative or exceeds the maximum allowed (%s seconds).
     */
    const SLAVE_HEARTBEAT_VALUE_OUT_OF_RANGE = 1624;

    /**
     * Bad schema for mysql.ndb_replication table. Message: %s
     */
    const NDB_REPLICATION_SCHEMA_ERROR = 1625;

    /**
     * Error in parsing conflict function. Message: %s
     */
    const CONFLICT_FN_PARSE_ERROR = 1626;

    /**
     * Write to exceptions table failed. Message: %s"
     */
    const EXCEPTIONS_WRITE_ERROR = 1627;

    /**
     * Comment for table '%s' is too long (max = %lu)
     */
    const TOO_LONG_TABLE_COMMENT = 1628;

    /**
     * Comment for field '%s' is too long (max = %lu)
     */
    const TOO_LONG_FIELD_COMMENT = 1629;

    /**
     * FUNCTION %s does not exist. Check the 'Function Name Parsing and Resolution' section in the Reference Manual
     */
    const FUNC_INEXISTENT_NAME_COLLISION = 1630;

    /**
     * Database
     */
    const DATABASE_NAME = 1631;

    /**
     * Table
     */
    const TABLE_NAME = 1632;

    /**
     * Partition
     */
    const PARTITION_NAME = 1633;

    /**
     * Subpartition
     */
    const SUBPARTITION_NAME = 1634;

    /**
     * Temporary
     */
    const TEMPORARY_NAME = 1635;

    /**
     * Renamed
     */
    const RENAMED_NAME = 1636;

    /**
     * Too many active concurrent transactions
     */
    const TOO_MANY_CONCURRENT_TRXS = 1637;

    /**
     * Non-ASCII separator arguments are not fully supported
     */
    const WARN_NON_ASCII_SEPARATOR_NOT_IMPLEMENTED = 1638;

    /**
     * debug sync point wait timed out
     */
    const DEBUG_SYNC_TIMEOUT = 1639;

    /**
     * debug sync point hit limit reached
     */
    const DEBUG_SYNC_HIT_LIMIT = 1640;

    /**
     * Duplicate condition information item '%s'
     */
    const DUP_SIGNAL_SET = 1641;

    /**
     * Unhandled user-defined warning condition
     */
    const SIGNAL_WARN = 1642;

    /**
     * Unhandled user-defined not found condition
     */
    const SIGNAL_NOT_FOUND = 1643;

    /**
     * Unhandled user-defined exception condition
     */
    const SIGNAL_EXCEPTION = 1644;

    /**
     * RESIGNAL when handler not active
     */
    const RESIGNAL_WITHOUT_ACTIVE_HANDLER = 1645;

    /**
     * SIGNAL/RESIGNAL can only use a CONDITION defined with SQLSTATE
     */
    const SIGNAL_BAD_CONDITION_TYPE = 1646;

    /**
     * Data truncated for condition item '%s'
     */
    const WARN_COND_ITEM_TRUNCATED = 1647;

    /**
     * Data too long for condition item '%s'
     */
    const COND_ITEM_TOO_LONG = 1648;

    /**
     * Unknown locale: '%s'
     */
    const UNKNOWN_LOCALE = 1649;

    /**
     * The requested server id %d clashes with the slave startup option --replicate-same-server-id
     */
    const SLAVE_IGNORE_SERVER_IDS = 1650;

    /**
     * Query cache is disabled; restart the server with query_cache_type=1 to enable it
     */
    const QUERY_CACHE_DISABLED = 1651;

    /**
     * Duplicate partition field name '%s'
     */
    const SAME_NAME_PARTITION_FIELD = 1652;

    /**
     * Inconsistency in usage of column lists for partitioning
     */
    const PARTITION_COLUMN_LIST_ERROR = 1653;

    /**
     * Partition column values of incorrect type
     */
    const WRONG_TYPE_COLUMN_VALUE_ERROR = 1654;

    /**
     * Too many fields in '%s'
     */
    const TOO_MANY_PARTITION_FUNC_FIELDS_ERROR = 1655;

    /**
     * Cannot use MAXVALUE as value in VALUES IN
     */
    const MAXVALUE_IN_VALUES_IN = 1656;

    /**
     * Cannot have more than one value for this type of %s partitioning
     */
    const TOO_MANY_VALUES_ERROR = 1657;

    /**
     * Row expressions in VALUES IN only allowed for multi-field column partitioning
     */
    const ROW_SINGLE_PARTITION_FIELD_ERROR = 1658;

    /**
     * Field '%s' is of a not allowed type for this type of partitioning
     */
    const FIELD_TYPE_NOT_ALLOWED_AS_PARTITION_FIELD = 1659;

    /**
     * The total length of the partitioning fields is too large
     */
    const PARTITION_FIELDS_TOO_LONG = 1660;

    /**
     * Cannot execute statement: impossible to write to binary log since both row-incapable engines and statement-incapable engines are involved.
     */
    const BINLOG_ROW_ENGINE_AND_STMT_ENGINE = 1661;

    /**
     * Cannot execute statement: impossible to write to binary log since BINLOG_FORMAT = ROW and at least one table uses a storage engine limited to statement-based logging.
     */
    const BINLOG_ROW_MODE_AND_STMT_ENGINE = 1662;

    /**
     * Cannot execute statement: impossible to write to binary log since statement is unsafe, storage engine is limited to statement-based logging, and BINLOG_FORMAT = MIXED. %s
     */
    const BINLOG_UNSAFE_AND_STMT_ENGINE = 1663;

    /**
     * Cannot execute statement: impossible to write to binary log since statement is in row format and at least one table uses a storage engine limited to statement-based logging.
     */
    const BINLOG_ROW_INJECTION_AND_STMT_ENGINE = 1664;

    /**
     * Cannot execute statement: impossible to write to binary log since BINLOG_FORMAT = STATEMENT and at least one table uses a storage engine limited to row-based logging.%s
     */
    const BINLOG_STMT_MODE_AND_ROW_ENGINE = 1665;

    /**
     * Cannot execute statement: impossible to write to binary log since statement is in row format and BINLOG_FORMAT = STATEMENT.
     */
    const BINLOG_ROW_INJECTION_AND_STMT_MODE = 1666;

    /**
     * Cannot execute statement: impossible to write to binary log since more than one engine is involved and at least one engine is self-logging.
     */
    const BINLOG_MULTIPLE_ENGINES_AND_SELF_LOGGING_ENGINE = 1667;

    /**
     * The statement is unsafe because it uses a LIMIT clause. This is unsafe because the set of rows included cannot be predicted.
     */
    const BINLOG_UNSAFE_LIMIT = 1668;

    /**
     * The statement is unsafe because it uses INSERT DELAYED. This is unsafe because the times when rows are inserted cannot be predicted.
     *
     * @deprecated Unused as of 5.7
     */
    const BINLOG_UNSAFE_INSERT_DELAYED = 1669;

    /**
     * The statement is unsafe because it uses the general log, slow query log, or performance_schema table(s). This is unsafe because system tables may differ on slaves.
     */
    const BINLOG_UNSAFE_SYSTEM_TABLE = 1670;

    /**
     * Statement is unsafe because it invokes a trigger or a stored function that inserts into an AUTO_INCREMENT column. Inserted values cannot be logged correctly.
     */
    const BINLOG_UNSAFE_AUTOINC_COLUMNS = 1671;

    /**
     * Statement is unsafe because it uses a UDF which may not return the same value on the slave.
     */
    const BINLOG_UNSAFE_UDF = 1672;

    /**
     * Statement is unsafe because it uses a system variable that may have a different value on the slave.
     */
    const BINLOG_UNSAFE_SYSTEM_VARIABLE = 1673;

    /**
     * Statement is unsafe because it uses a system function that may return a different value on the slave.
     */
    const BINLOG_UNSAFE_SYSTEM_FUNCTION = 1674;

    /**
     * Statement is unsafe because it accesses a non-transactional table after accessing a transactional table within the same transaction.
     */
    const BINLOG_UNSAFE_NONTRANS_AFTER_TRANS = 1675;

    /**
     * %s Statement: %s
     */
    const MESSAGE_AND_STATEMENT = 1676;

    /**
     * Column %d of table '%s.%s' cannot be converted from type '%s' to type '%s'
     */
    const SLAVE_CONVERSION_FAILED = 1677;

    /**
     * Can't create conversion table for table '%s.%s'
     */
    const SLAVE_CANT_CREATE_CONVERSION = 1678;

    /**
     * Cannot modify @@session.binlog_format inside a transaction
     */
    const INSIDE_TRANSACTION_PREVENTS_SWITCH_BINLOG_FORMAT = 1679;

    /**
     * The path specified for %s is too long.
     */
    const PATH_LENGTH = 1680;

    /**
     * '%s' is deprecated and will be removed in a future release.
     */
    const WARN_DEPRECATED_SYNTAX_NO_REPLACEMENT = 1681;

    /**
     * Native table '%s'.'%s' has the wrong structure
     */
    const WRONG_NATIVE_TABLE_STRUCTURE = 1682;

    /**
     * Invalid performance_schema usage.
     */
    const WRONG_PERFSCHEMA_USAGE = 1683;

    /**
     * Table '%s'.'%s' was skipped since its definition is being modified by concurrent DDL statement
     */
    const WARN_I_S_SKIPPED_TABLE = 1684;

    /**
     * Cannot modify @@session.binlog_direct_non_transactional_updates inside a transaction
     */
    const INSIDE_TRANSACTION_PREVENTS_SWITCH_BINLOG_DIRECT = 1685;

    /**
     * Cannot change the binlog direct flag inside a stored function or trigger
     */
    const STORED_FUNCTION_PREVENTS_SWITCH_BINLOG_DIRECT = 1686;

    /**
     * A SPATIAL index may only contain a geometrical type column
     */
    const SPATIAL_MUST_HAVE_GEOM_COL = 1687;

    /**
     * Comment for index '%s' is too long (max = %lu)
     */
    const TOO_LONG_INDEX_COMMENT = 1688;

    /**
     * Wait on a lock was aborted due to a pending exclusive lock
     */
    const LOCK_ABORTED = 1689;

    /**
     * %s value is out of range in '%s'
     */
    const DATA_OUT_OF_RANGE = 1690;

    /**
     * A variable of a non-integer based type in LIMIT clause
     */
    const WRONG_SPVAR_TYPE_IN_LIMIT = 1691;

    /**
     * Mixing self-logging and non-self-logging engines in a statement is unsafe.
     */
    const BINLOG_UNSAFE_MULTIPLE_ENGINES_AND_SELF_LOGGING_ENGINE = 1692;

    /**
     * Statement accesses nontransactional table as well as transactional or temporary table, and writes to any of them.
     */
    const BINLOG_UNSAFE_MIXED_STATEMENT = 1693;

    /**
     * Cannot modify @@session.sql_log_bin inside a transaction
     */
    const INSIDE_TRANSACTION_PREVENTS_SWITCH_SQL_LOG_BIN = 1694;

    /**
     * Cannot change the sql_log_bin inside a stored function or trigger
     */
    const STORED_FUNCTION_PREVENTS_SWITCH_SQL_LOG_BIN = 1695;

    /**
     * Failed to read from the .par file
     */
    const FAILED_READ_FROM_PAR_FILE = 1696;

    /**
     * VALUES value for partition '%s' must have type INT
     */
    const VALUES_IS_NOT_INT_TYPE_ERROR = 1697;

    /**
     * Access denied for user '%s'@'%s'
     */
    const ACCESS_DENIED_NO_PASSWORD_ERROR = 1698;

    /**
     * SET PASSWORD has no significance for users authenticating via plugins
     */
    const SET_PASSWORD_AUTH_PLUGIN = 1699;

    /**
     * GRANT with IDENTIFIED WITH is illegal because the user %-.*s already exists
     */
    const GRANT_PLUGIN_USER_EXISTS = 1700;

    /**
     * Cannot truncate a table referenced in a foreign key constraint (%s)
     */
    const TRUNCATE_ILLEGAL_FK = 1701;

    /**
     * Plugin '%s' is force_plus_permanent and can not be unloaded
     */
    const PLUGIN_IS_PERMANENT = 1702;

    /**
     * The requested value for the heartbeat period is less than 1 millisecond. The value is reset to 0, meaning that heartbeating will effectively be disabled.
     */
    const SLAVE_HEARTBEAT_VALUE_OUT_OF_RANGE_MIN = 1703;

    /**
     * The requested value for the heartbeat period exceeds the value of `slave_net_timeout' seconds. A sensible value for the period should be less than the timeout.
     */
    const SLAVE_HEARTBEAT_VALUE_OUT_OF_RANGE_MAX = 1704;

    /**
     * Multi-row statements required more than 'max_binlog_stmt_cache_size' bytes of storage; increase this mysqld variable and try again
     */
    const STMT_CACHE_FULL = 1705;

    /**
     * Primary key/partition key update is not allowed since the table is updated both as '%s' and '%s'.
     */
    const MULTI_UPDATE_KEY_CONFLICT = 1706;

    /**
     * Table rebuild required. Please do "ALTER TABLE `%s` FORCE" or dump/reload to fix it!
     */
    const TABLE_NEEDS_REBUILD = 1707;

    /**
     * The value of '%s' should be no less than the value of '%s'
     */
    const WARN_OPTION_BELOW_LIMIT = 1708;

    /**
     * Index column size too large. The maximum column size is %lu bytes.
     */
    const INDEX_COLUMN_TOO_LONG = 1709;

    /**
     * Trigger '%s' has an error in its body: '%s'
     */
    const ERROR_IN_TRIGGER_BODY = 1710;

    /**
     * Unknown trigger has an error in its body: '%s'
     */
    const ERROR_IN_UNKNOWN_TRIGGER_BODY = 1711;

    /**
     * Index %s is corrupted
     */
    const INDEX_CORRUPT = 1712;

    /**
     * Undo log record is too big.
     */
    const UNDO_RECORD_TOO_BIG = 1713;

    /**
     * INSERT IGNORE... SELECT is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are ignored. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_INSERT_IGNORE_SELECT = 1714;

    /**
     * INSERT... SELECT... ON DUPLICATE KEY UPDATE is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are updated. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_INSERT_SELECT_UPDATE = 1715;

    /**
     * REPLACE... SELECT is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are replaced. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_REPLACE_SELECT = 1716;

    /**
     * CREATE... IGNORE SELECT is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are ignored. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_CREATE_IGNORE_SELECT = 1717;

    /**
     * CREATE... REPLACE SELECT is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are replaced. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_CREATE_REPLACE_SELECT = 1718;

    /**
     * UPDATE IGNORE is unsafe because the order in which rows are updated determines which (if any) rows are ignored. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_UPDATE_IGNORE = 1719;

    /**
     * Plugin '%s' is marked as not dynamically uninstallable. You have to stop the server to uninstall it.
     */
    const PLUGIN_NO_UNINSTALL = 1720;

    /**
     * Plugin '%s' is marked as not dynamically installable. You have to stop the server to install it.
     */
    const PLUGIN_NO_INSTALL = 1721;

    /**
     * Statements writing to a table with an auto-increment column after selecting from another table are unsafe because the order in which rows are retrieved determines what (if any) rows will be written. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_WRITE_AUTOINC_SELECT = 1722;

    /**
     * CREATE TABLE... SELECT... on a table with an auto-increment column is unsafe because the order in which rows are retrieved by the SELECT determines which (if any) rows are inserted. This order cannot be predicted and may differ on master and the slave.
     */
    const BINLOG_UNSAFE_CREATE_SELECT_AUTOINC = 1723;

    /**
     * INSERT... ON DUPLICATE KEY UPDATE on a table with more than one UNIQUE KEY is unsafe
     */
    const BINLOG_UNSAFE_INSERT_TWO_KEYS = 1724;

    /**
     * Table is being used in foreign key check.
     */
    const TABLE_IN_FK_CHECK = 1725;

    /**
     * Storage engine '%s' does not support system tables. [%s.%s]
     */
    const UNSUPPORTED_ENGINE = 1726;

    /**
     * INSERT into autoincrement field which is not the first part in the composed primary key is unsafe.
     */
    const BINLOG_UNSAFE_AUTOINC_NOT_FIRST = 1727;

    /**
     * Cannot load from %s.%s. The table is probably corrupted
     */
    const CANNOT_LOAD_FROM_TABLE_V2 = 1728;

    /**
     * The requested value %s for the master delay exceeds the maximum %u
     */
    const MASTER_DELAY_VALUE_OUT_OF_RANGE = 1729;

    /**
     * Only Format_description_log_event and row events are allowed in BINLOG statements (but %s was provided)
     */
    const ONLY_FD_AND_RBR_EVENTS_ALLOWED_IN_BINLOG_STATEMENT = 1730;

    /**
     * Non matching attribute '%s' between partition and table
     */
    const PARTITION_EXCHANGE_DIFFERENT_OPTION = 1731;

    /**
     * Table to exchange with partition is partitioned: '%s'
     */
    const PARTITION_EXCHANGE_PART_TABLE = 1732;

    /**
     * Table to exchange with partition is temporary: '%s'
     */
    const PARTITION_EXCHANGE_TEMP_TABLE = 1733;

    /**
     * Subpartitioned table, use subpartition instead of partition
     */
    const PARTITION_INSTEAD_OF_SUBPARTITION = 1734;

    /**
     * Unknown partition '%s' in table '%s'
     */
    const UNKNOWN_PARTITION = 1735;

    /**
     * Tables have different definitions
     */
    const TABLES_DIFFERENT_METADATA = 1736;

    /**
     * Found a row that does not match the partition
     */
    const ROW_DOES_NOT_MATCH_PARTITION = 1737;

    /**
     * Option binlog_cache_size (%lu) is greater than max_binlog_cache_size (%lu); setting binlog_cache_size equal to max_binlog_cache_size.
     */
    const BINLOG_CACHE_SIZE_GREATER_THAN_MAX = 1738;

    /**
     * Cannot use %s access on index '%s' due to type or collation conversion on field '%s'
     */
    const WARN_INDEX_NOT_APPLICABLE = 1739;

    /**
     * Table to exchange with partition has foreign key references: '%s'
     */
    const PARTITION_EXCHANGE_FOREIGN_KEY = 1740;

    /**
     * Key value '%s' was not found in table '%s.%s'
     */
    const NO_SUCH_KEY_VALUE = 1741;

    /**
     * Data for column '%s' too long
     */
    const RPL_INFO_DATA_TOO_LONG = 1742;

    /**
     * Replication event checksum verification failed while reading from network.
     */
    const NETWORK_READ_EVENT_CHECKSUM_FAILURE = 1743;

    /**
     * Replication event checksum verification failed while reading from a log file.
     */
    const BINLOG_READ_EVENT_CHECKSUM_FAILURE = 1744;

    /**
     * Option binlog_stmt_cache_size (%lu) is greater than max_binlog_stmt_cache_size (%lu); setting binlog_stmt_cache_size equal to max_binlog_stmt_cache_size.
     */
    const BINLOG_STMT_CACHE_SIZE_GREATER_THAN_MAX = 1745;

    /**
     * Can't update table '%s' while '%s' is being created.
     */
    const CANT_UPDATE_TABLE_IN_CREATE_TABLE_SELECT = 1746;

    /**
     * PARTITION () clause on non partitioned table
     */
    const PARTITION_CLAUSE_ON_NONPARTITIONED = 1747;

    /**
     * Found a row not matching the given partition set
     */
    const ROW_DOES_NOT_MATCH_GIVEN_PARTITION_SET = 1748;

    /**
     * partition '%s' doesn't exist
     */
    const NO_SUCH_PARTITION__UNUSED = 1749;

    /**
     * Failure while changing the type of replication repository: %s.
     */
    const CHANGE_RPL_INFO_REPOSITORY_FAILURE = 1750;

    /**
     * The creation of some temporary tables could not be rolled back.
     */
    const WARNING_NOT_COMPLETE_ROLLBACK_WITH_CREATED_TEMP_TABLE = 1751;

    /**
     * Some temporary tables were dropped, but these operations could not be rolled back.
     */
    const WARNING_NOT_COMPLETE_ROLLBACK_WITH_DROPPED_TEMP_TABLE = 1752;

    /**
     * %s is not supported in multi-threaded slave mode. %s
     */
    const MTS_FEATURE_IS_NOT_SUPPORTED = 1753;

    /**
     * The number of modified databases exceeds the maximum %d; the database names will not be included in the replication event metadata.
     */
    const MTS_UPDATED_DBS_GREATER_MAX = 1754;

    /**
     * Cannot execute the current event group in the parallel mode. Encountered event %s, relay-log name %s, position %s which prevents execution of this event group in parallel mode. Reason: %s.
     */
    const MTS_CANT_PARALLEL = 1755;

    /**
     * %s
     */
    const MTS_INCONSISTENT_DATA = 1756;

    /**
     * FULLTEXT index is not supported for partitioned tables.
     */
    const FULLTEXT_NOT_SUPPORTED_WITH_PARTITIONING = 1757;

    /**
     * Invalid condition number
     */
    const DA_INVALID_CONDITION_NUMBER = 1758;

    /**
     * Sending passwords in plain text without SSL/TLS is extremely insecure.
     */
    const INSECURE_PLAIN_TEXT = 1759;

    /**
     * Storing MySQL user name or password information in the master info repository is not secure and is therefore not recommended. Please consider using the USER and PASSWORD connection options for START SLAVE; see the 'START SLAVE Syntax' in the MySQL Manual for more information.
     */
    const INSECURE_CHANGE_MASTER = 1760;

    /**
     * Foreign key constraint for table '%s', record '%s' would lead to a duplicate entry in table '%s', key '%s'
     */
    const FOREIGN_DUPLICATE_KEY_WITH_CHILD_INFO = 1761;

    /**
     * Foreign key constraint for table '%s', record '%s' would lead to a duplicate entry in a child table
     */
    const FOREIGN_DUPLICATE_KEY_WITHOUT_CHILD_INFO = 1762;

    /**
     * Setting authentication options is not possible when only the Slave SQL Thread is being started.
     */
    const SQLTHREAD_WITH_SECURE_SLAVE = 1763;

    /**
     * The table does not have FULLTEXT index to support this query
     */
    const TABLE_HAS_NO_FT = 1764;

    /**
     * The system variable %s cannot be set in stored functions or triggers.
     */
    const VARIABLE_NOT_SETTABLE_IN_SF_OR_TRIGGER = 1765;

    /**
     * The system variable %s cannot be set when there is an ongoing transaction.
     */
    const VARIABLE_NOT_SETTABLE_IN_TRANSACTION = 1766;

    /**
     * The system variable @@SESSION.GTID_NEXT has the value %s, which is not listed in @@SESSION.GTID_NEXT_LIST.
     */
    const GTID_NEXT_IS_NOT_IN_GTID_NEXT_LIST = 1767;

    /**
     * The system variable @@SESSION.GTID_NEXT cannot change inside a transaction.
     *
     * @deprecated Removed after 5.7.5
     */
    const CANT_CHANGE_GTID_NEXT_IN_TRANSACTION_WHEN_GTID_NEXT_LIST_IS_NULL = 1768;

    /**
     * The system variable @@SESSION.GTID_NEXT cannot change inside a transaction.
     *
     * @since 5.7.6
     */
    const CANT_CHANGE_GTID_NEXT_IN_TRANSACTION = 1768;

    /**
     * The statement 'SET %s' cannot invoke a stored function.
     */
    const SET_STATEMENT_CANNOT_INVOKE_FUNCTION = 1769;

    /**
     * The system variable @@SESSION.GTID_NEXT cannot be 'AUTOMATIC' when @@SESSION.GTID_NEXT_LIST is non-NULL.
     */
    const GTID_NEXT_CANT_BE_AUTOMATIC_IF_GTID_NEXT_LIST_IS_NON_NULL = 1770;

    /**
     * Skipping transaction %s because it has already been executed and logged.
     */
    const SKIPPING_LOGGED_TRANSACTION = 1771;

    /**
     * Malformed GTID set specification '%s'.
     */
    const MALFORMED_GTID_SET_SPECIFICATION = 1772;

    /**
     * Malformed GTID set encoding.
     */
    const MALFORMED_GTID_SET_ENCODING = 1773;

    /**
     * Malformed GTID specification '%s'.
     */
    const MALFORMED_GTID_SPECIFICATION = 1774;

    /**
     * Impossible to generate Global Transaction Identifier: the integer component reached the maximal value. Restart the server with a new server_uuid.
     */
    const GNO_EXHAUSTED = 1775;

    /**
     * Parameters MASTER_LOG_FILE, MASTER_LOG_POS, RELAY_LOG_FILE and RELAY_LOG_POS cannot be set when MASTER_AUTO_POSITION is active.
     */
    const BAD_SLAVE_AUTO_POSITION = 1776;

    /**
     * CHANGE MASTER TO MASTER_AUTO_POSITION = 1 can only be executed when @@GLOBAL.GTID_MODE = ON.
     *
     * @deprecated Removed after 5.7.5
     */
    const AUTO_POSITION_REQUIRES_GTID_MODE_ON = 1777;

    /**
     * CHANGE MASTER TO MASTER_AUTO_POSITION = 1 cannot be executed because @@GLOBAL.GTID_MODE = OFF.
     *
     * @since 5.7.6
     */
    const AUTO_POSITION_REQUIRES_GTID_MODE_NOT_OFF = 1777;

    /**
     * Cannot execute statements with implicit commit inside a transaction when @@SESSION.GTID_NEXT == 'UUID:NUMBER'.
     */
    const CANT_DO_IMPLICIT_COMMIT_IN_TRX_WHEN_GTID_NEXT_IS_SET = 1778;

    /**
     * @@GLOBAL.GTID_MODE = ON or UPGRADE_STEP_2 requires @@GLOBAL.ENFORCE_GTID_CONSISTENCY = 1.
     *
     * @deprecated Removed after 5.7.5
     */
    const GTID_MODE_2_OR_3_REQUIRES_ENFORCE_GTID_CONSISTENCY_ON = 1779;

    /**
     * GTID_MODE = ON requires ENFORCE_GTID_CONSISTENCY = ON.
     *
     * @since 5.7.6
     */
    const GTID_MODE_ON_REQUIRES_ENFORCE_GTID_CONSISTENCY_ON = 1779;

    /**
     * @@GLOBAL.GTID_MODE = ON or ON_PERMISSIVE or OFF_PERMISSIVE requires --log-bin and --log-slave-updates.
     */
    const GTID_MODE_REQUIRES_BINLOG = 1780;

    /**
     * @@SESSION.GTID_NEXT cannot be set to UUID:NUMBER when @@GLOBAL.GTID_MODE = OFF.
     */
    const CANT_SET_GTID_NEXT_TO_GTID_WHEN_GTID_MODE_IS_OFF = 1781;

    /**
     * @@SESSION.GTID_NEXT cannot be set to ANONYMOUS when @@GLOBAL.GTID_MODE = ON.
     */
    const CANT_SET_GTID_NEXT_TO_ANONYMOUS_WHEN_GTID_MODE_IS_ON = 1782;

    /**
     * @@SESSION.GTID_NEXT_LIST cannot be set to a non-NULL value when @@GLOBAL.GTID_MODE = OFF.
     */
    const CANT_SET_GTID_NEXT_LIST_TO_NON_NULL_WHEN_GTID_MODE_IS_OFF = 1783;

    /**
     * Found a Gtid_log_event or Previous_gtids_log_event when @@GLOBAL.GTID_MODE = OFF.
     *
     * @deprecated Removed after 5.7.5
     */
    const FOUND_GTID_EVENT_WHEN_GTID_MODE_IS_OFF = 1784;

    /**
     * Found a Gtid_log_event when @@GLOBAL.GTID_MODE = OFF.
     *
     * @since 5.7.6
     */
    const FOUND_GTID_EVENT_WHEN_GTID_MODE_IS_OFF__UNUSED = 1784;

    /**
     * Statement violates GTID consistency: Updates to non-transactional tables can only be done in either autocommitted statements or single-statement transactions, and never in the same statement as updates to transactional tables.
     */
    const GTID_UNSAFE_NON_TRANSACTIONAL_TABLE = 1785;

    /**
     * Statement violates GTID consistency: CREATE TABLE ... SELECT.
     */
    const GTID_UNSAFE_CREATE_SELECT = 1786;

    /**
     * Statement violates GTID consistency: CREATE TEMPORARY TABLE and DROP TEMPORARY TABLE can only be executed outside transactional context. These statements are also not allowed in a function or trigger because functions and triggers are also considered to be multi-statement transactions.
     */
    const GTID_UNSAFE_CREATE_DROP_TEMPORARY_TABLE_IN_TRANSACTION = 1787;

    /**
     * The value of @@GLOBAL.GTID_MODE can only be changed one step at a time: OFF <-> OFF_PERMISSIVE <-> ON_PERMISSIVE <-> ON. Also note that this value must be stepped up or down simultaneously on all servers. See the Manual for instructions.
     */
    const GTID_MODE_CAN_ONLY_CHANGE_ONE_STEP_AT_A_TIME = 1788;

    /**
     * The slave is connecting using CHANGE MASTER TO MASTER_AUTO_POSITION = 1, but the master has purged binary logs containing GTIDs that the slave requires.
     */
    const MASTER_HAS_PURGED_REQUIRED_GTIDS = 1789;

    /**
     * @@SESSION.GTID_NEXT cannot be changed by a client that owns a GTID. The client owns %s. Ownership is released on COMMIT or ROLLBACK.
     */
    const CANT_SET_GTID_NEXT_WHEN_OWNING_GTID = 1790;

    /**
     * Unknown EXPLAIN format name: '%s'
     */
    const UNKNOWN_EXPLAIN_FORMAT = 1791;

    /**
     * Cannot execute statement in a READ ONLY transaction.
     */
    const CANT_EXECUTE_IN_READ_ONLY_TRANSACTION = 1792;

    /**
     * Comment for table partition '%s' is too long (max = %lu)
     */
    const TOO_LONG_TABLE_PARTITION_COMMENT = 1793;

    /**
     * Slave is not configured or failed to initialize properly. You must at least set --server-id to enable either a master or a slave. Additional error messages can be found in the MySQL error log.
     */
    const SLAVE_CONFIGURATION = 1794;

    /**
     * InnoDB presently supports one FULLTEXT index creation at a time
     */
    const INNODB_FT_LIMIT = 1795;

    /**
     * Cannot create FULLTEXT index on temporary InnoDB table
     */
    const INNODB_NO_FT_TEMP_TABLE = 1796;

    /**
     * Column '%s' is of wrong type for an InnoDB FULLTEXT index
     */
    const INNODB_FT_WRONG_DOCID_COLUMN = 1797;

    /**
     * Index '%s' is of wrong type for an InnoDB FULLTEXT index
     */
    const INNODB_FT_WRONG_DOCID_INDEX = 1798;

    /**
     * Creating index '%s' required more than 'innodb_online_alter_log_max_size' bytes of modification log. Please try again.
     */
    const INNODB_ONLINE_LOG_TOO_BIG = 1799;

    /**
     * Unknown ALGORITHM '%s'
     */
    const UNKNOWN_ALTER_ALGORITHM = 1800;

    /**
     * Unknown LOCK type '%s'
     */
    const UNKNOWN_ALTER_LOCK = 1801;

    /**
     * CHANGE MASTER cannot be executed when the slave was stopped with an error or killed in MTS mode. Consider using RESET SLAVE or START SLAVE UNTIL.
     */
    const MTS_CHANGE_MASTER_CANT_RUN_WITH_GAPS = 1802;

    /**
     * Cannot recover after SLAVE errored out in parallel execution mode. Additional error messages can be found in the MySQL error log.
     */
    const MTS_RECOVERY_FAILURE = 1803;

    /**
     * Cannot clean up worker info tables. Additional error messages can be found in the MySQL error log.
     */
    const MTS_RESET_WORKERS = 1804;

    /**
     * Column count of %s.%s is wrong. Expected %d, found %d. The table is probably corrupted
     */
    const COL_COUNT_DOESNT_MATCH_CORRUPTED_V2 = 1805;

    /**
     * Slave must silently retry current transaction
     */
    const SLAVE_SILENT_RETRY_TRANSACTION = 1806;

    /**
     * There is a foreign key check running on table '%s'. Cannot discard the table.
     */
    const DISCARD_FK_CHECKS_RUNNING = 1807;

    /**
     * Schema mismatch (%s)
     */
    const TABLE_SCHEMA_MISMATCH = 1808;

    /**
     * Table '%s' in system tablespace
     */
    const TABLE_IN_SYSTEM_TABLESPACE = 1809;

    /**
     * IO Read error: (%lu, %s) %s
     */
    const IO_READ_ERROR = 1810;

    /**
     * IO Write error: (%lu, %s) %s
     */
    const IO_WRITE_ERROR = 1811;

    /**
     * Tablespace is missing for table %s.
     */
    const TABLESPACE_MISSING = 1812;

    /**
     * Tablespace '%s' exists.
     */
    const TABLESPACE_EXISTS = 1813;

    /**
     * Tablespace has been discarded for table '%s'
     */
    const TABLESPACE_DISCARDED = 1814;

    /**
     * Internal error: %s
     */
    const INTERNAL_ERROR = 1815;

    /**
     * ALTER TABLE %s IMPORT TABLESPACE failed with error %lu : '%s'
     */
    const INNODB_IMPORT_ERROR = 1816;

    /**
     * Index corrupt: %s
     */
    const INNODB_INDEX_CORRUPT = 1817;

    /**
     * Supports only YEAR or YEAR(4) column.
     */
    const INVALID_YEAR_COLUMN_LENGTH = 1818;

    /**
     * Your password does not satisfy the current policy requirements
     */
    const NOT_VALID_PASSWORD = 1819;

    /**
     * You must reset your password using ALTER USER statement before executing this statement.
     */
    const MUST_CHANGE_PASSWORD = 1820;

    /**
     * Failed to add the foreign key constaint. Missing index for constraint '%s' in the foreign table '%s'
     */
    const FK_NO_INDEX_CHILD = 1821;

    /**
     * Failed to add the foreign key constaint. Missing index for constraint '%s' in the referenced table '%s'
     */
    const FK_NO_INDEX_PARENT = 1822;

    /**
     * Failed to add the foreign key constraint '%s' to system tables
     */
    const FK_FAIL_ADD_SYSTEM = 1823;

    /**
     * Failed to open the referenced table '%s'
     */
    const FK_CANNOT_OPEN_PARENT = 1824;

    /**
     * Failed to add the foreign key constraint on table '%s'. Incorrect options in FOREIGN KEY constraint '%s'
     */
    const FK_INCORRECT_OPTION = 1825;

    /**
     * Duplicate foreign key constraint name '%s'
     */
    const FK_DUP_NAME = 1826;

    /**
     * The password hash doesn't have the expected format. Check if the correct password algorithm is being used with the PASSWORD() function.
     */
    const PASSWORD_FORMAT = 1827;

    /**
     * Cannot drop column '%s': needed in a foreign key constraint '%s'
     */
    const FK_COLUMN_CANNOT_DROP = 1828;

    /**
     * Cannot drop column '%s': needed in a foreign key constraint '%s' of table '%s'
     */
    const FK_COLUMN_CANNOT_DROP_CHILD = 1829;

    /**
     * Column '%s' cannot be NOT NULL: needed in a foreign key constraint '%s' SET NULL
     */
    const FK_COLUMN_NOT_NULL = 1830;

    /**
     * Duplicate index '%s' defined on the table '%s.%s'. This is deprecated and will be disallowed in a future release.
     */
    const DUP_INDEX = 1831;

    /**
     * Cannot change column '%s': used in a foreign key constraint '%s'
     */
    const FK_COLUMN_CANNOT_CHANGE = 1832;

    /**
     * Cannot change column '%s': used in a foreign key constraint '%s' of table '%s'
     */
    const FK_COLUMN_CANNOT_CHANGE_CHILD = 1833;

    /**
     * Cannot delete rows from table which is parent in a foreign key constraint '%s' of table '%s'
     *
     * @since 5.6.7
     * @deprecated Removed after 5.7.3
     */
    const FK_CANNOT_DELETE_PARENT = 1834;

    /**
     * Malformed communication packet.
     */
    const MALFORMED_PACKET = 1835;

    /**
     * Running in read-only mode
     */
    const READ_ONLY_MODE = 1836;

    /**
     * When @@SESSION.GTID_NEXT is set to a GTID, you must explicitly set it to a different value after a COMMIT or ROLLBACK. Please check GTID_NEXT variable manual page for detailed explanation. Current @@SESSION.GTID_NEXT is '%s'.
     */
    const GTID_NEXT_TYPE_UNDEFINED_GROUP = 1837;

    /**
     * The system variable %s cannot be set in stored procedures.
     */
    const VARIABLE_NOT_SETTABLE_IN_SP = 1838;

    /**
     * @@GLOBAL.GTID_PURGED can only be set when @@GLOBAL.GTID_MODE = ON.
     */
    const CANT_SET_GTID_PURGED_WHEN_GTID_MODE_IS_OFF = 1839;

    /**
     * @@GLOBAL.GTID_PURGED can only be set when @@GLOBAL.GTID_EXECUTED is empty.
     */
    const CANT_SET_GTID_PURGED_WHEN_GTID_EXECUTED_IS_NOT_EMPTY = 1840;

    /**
     * @@GLOBAL.GTID_PURGED can only be set when there are no ongoing transactions (not even in other clients).
     */
    const CANT_SET_GTID_PURGED_WHEN_OWNED_GTIDS_IS_NOT_EMPTY = 1841;

    /**
     * @@GLOBAL.GTID_PURGED was changed from '%s' to '%s'.
     */
    const GTID_PURGED_WAS_CHANGED = 1842;

    /**
     * @@GLOBAL.GTID_EXECUTED was changed from '%s' to '%s'.
     */
    const GTID_EXECUTED_WAS_CHANGED = 1843;

    /**
     * Cannot execute statement: impossible to write to binary log since BINLOG_FORMAT = STATEMENT, and both replicated and non replicated tables are written to.
     */
    const BINLOG_STMT_MODE_AND_NO_REPL_TABLES = 1844;

    /**
     * %s is not supported for this operation. Try %s.
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED = 1845;

    /**
     * %s is not supported. Reason: %s. Try %s.
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON = 1846;

    /**
     * COPY algorithm requires a lock
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_COPY = 1847;

    /**
     * Partition specific operations do not yet support LOCK/ALGORITHM
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_PARTITION = 1848;

    /**
     * Columns participating in a foreign key are renamed
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_FK_RENAME = 1849;

    /**
     * Cannot change column type INPLACE
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_COLUMN_TYPE = 1850;

    /**
     * Adding foreign keys needs foreign_key_checks=OFF
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_FK_CHECK = 1851;

    /**
     * Creating unique indexes with IGNORE requires COPY algorithm to remove duplicate rows
     *
     * @since 5.7.1
     * @deprecated Removed after 5.7.3
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_IGNORE = 1852;

    /**
     * Dropping a primary key is not allowed without also adding a new primary key
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_NOPK = 1853;

    /**
     * Adding an auto-increment column requires a lock
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_AUTOINC = 1854;

    /**
     * Cannot replace hidden FTS_DOC_ID with a user-visible one
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_HIDDEN_FTS = 1855;

    /**
     * Cannot drop or rename FTS_DOC_ID
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_CHANGE_FTS = 1856;

    /**
     * Fulltext index creation requires a lock
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_FTS = 1857;

    /**
     * sql_slave_skip_counter can not be set when the server is running with @@GLOBAL.GTID_MODE = ON. Instead, for each transaction that you want to skip, generate an empty transaction with the same GTID as the transaction
     *
     * @since 5.7.1
     */
    const SQL_SLAVE_SKIP_COUNTER_NOT_SETTABLE_IN_GTID_MODE = 1858;

    /**
     * Duplicate entry for key '%s'
     *
     * @since 5.7.1
     */
    const DUP_UNKNOWN_IN_INDEX = 1859;

    /**
     * Long database name and identifier for object resulted in path length exceeding %d characters. Path: '%s'.
     *
     * @since 5.7.1
     */
    const IDENT_CAUSES_TOO_LONG_PATH = 1860;

    /**
     * cannot silently convert NULL values, as required in this SQL_MODE
     *
     * @since 5.7.1
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_NOT_NULL = 1861;

    /**
     * Your password has expired. To log in you must change it using a client that supports expired passwords.
     *
     * @since 5.7.1
     */
    const MUST_CHANGE_PASSWORD_LOGIN = 1862;

    /**
     * Found a row in wrong partition %s
     *
     * @since 5.7.1
     */
    const ROW_IN_WRONG_PARTITION = 1863;

    /**
     * Cannot schedule event %s, relay-log name %s, position %s to Worker thread because its size %lu exceeds %lu of slave_pending_jobs_size_max.
     *
     * @since 5.7.2
     */
    const MTS_EVENT_BIGGER_PENDING_JOBS_SIZE_MAX = 1864;

    /**
     * Cannot CREATE FULLTEXT INDEX WITH PARSER on InnoDB table
     *
     * @since 5.7.2
     */
    const INNODB_NO_FT_USES_PARSER = 1865;

    /**
     * The binary log file '%s' is logically corrupted: %s
     *
     * @since 5.7.2
     */
    const BINLOG_LOGICAL_CORRUPTION = 1866;

    /**
     * file %s was not purged because it was being read by %d thread(s), purged only %d out of %d files.
     *
     * @since 5.7.2
     */
    const WARN_PURGE_LOG_IN_USE = 1867;

    /**
     * file %s was not purged because it is the active log file.
     *
     * @since 5.7.2
     */
    const WARN_PURGE_LOG_IS_ACTIVE = 1868;

    /**
     * Auto-increment value in UPDATE conflicts with internally generated values
     *
     * @since 5.7.2
     */
    const AUTO_INCREMENT_CONFLICT = 1869;

    /**
     * Row events are not logged for %s statements that modify BLACKHOLE tables in row format. Table(s): '%s'
     *
     * @since 5.7.2
     */
    const WARN_ON_BLOCKHOLE_IN_RBR = 1870;

    /**
     * Slave failed to initialize master info structure from the repository
     *
     * @since 5.7.2
     */
    const SLAVE_MI_INIT_REPOSITORY = 1871;

    /**
     * Slave failed to initialize relay log info structure from the repository
     *
     * @since 5.7.2
     */
    const SLAVE_RLI_INIT_REPOSITORY = 1872;

    /**
     * Access denied trying to change to user '%s'@'%s' (using password: %s). Disconnecting.
     *
     * @since 5.7.2
     */
    const ACCESS_DENIED_CHANGE_USER_ERROR = 1873;

    /**
     * InnoDB is in read only mode.
     *
     * @since 5.7.2
     */
    const INNODB_READ_ONLY = 1874;

    /**
     * STOP SLAVE command execution is incomplete: Slave SQL thread got the stop signal, thread is busy, SQL thread will stop once the current task is complete.
     *
     * @since 5.7.2
     */
    const STOP_SLAVE_SQL_THREAD_TIMEOUT = 1875;

    /**
     * STOP SLAVE command execution is incomplete: Slave IO thread got the stop signal, thread is busy, IO thread will stop once the current task is complete.
     *
     * @since 5.7.2
     */
    const STOP_SLAVE_IO_THREAD_TIMEOUT = 1876;

    /**
     * Operation cannot be performed. The table '%s.%s' is missing, corrupt or contains bad data.
     *
     * @since 5.7.2
     */
    const TABLE_CORRUPT = 1877;

    /**
     * Temporary file write failure.
     *
     * @since 5.7.3
     */
    const TEMP_FILE_WRITE_FAILURE = 1878;

    /**
     * Upgrade index name failed, please use create index(alter table) algorithm copy to rebuild index.
     *
     * @since 5.7.4
     */
    const INNODB_FT_AUX_NOT_HEX_ID = 1879;

    /**
     * TIME/TIMESTAMP/DATETIME columns of old format have been upgraded to the new format.
     *
     * @since 5.7.4
     */
    const OLD_TEMPORALS_UPGRADED = 1880;

    /**
     * Operation not allowed when innodb_forced_recovery > 0.
     *
     * @since 5.7.4
     */
    const INNODB_FORCED_RECOVERY = 1881;

    /**
     * The initialization vector supplied to %s is too short. Must be at least %d bytes long
     *
     * @since 5.7.4
     */
    const AES_INVALID_IV = 1882;

    /**
     * Plugin '%s' cannot be uninstalled now. %s
     *
     * @since 5.7.5
     */
    const PLUGIN_CANNOT_BE_UNINSTALLED = 1883;

    /**
     * Cannot execute statement because it needs to be written to the binary log as multiple statements, and this is not allowed when @@SESSION.GTID_NEXT == 'UUID:NUMBER'.
     *
     * @since 5.7.5
     */
    const GTID_UNSAFE_BINLOG_SPLITTABLE_STATEMENT_AND_GTID_GROUP = 1884;

    /**
     * Slave has more GTIDs than the master has, using the master's SERVER_UUID. This may indicate that the end of the binary log was truncated or that the last binary log file was lost, e.g., after a power or disk failure when sync_binlog != 1. The master may or may not have rolled back transactions that were already replicated to the slave. Suggest to replicate any transactions that master has rolled back from slave to master, and/or commit empty transactions on master to account for transactions that have been committed on master but are not included in GTID_EXECUTED.
     *
     * @since 5.7.6
     */
    const SLAVE_HAS_MORE_GTIDS_THAN_MASTER = 1885;

    /**
     * This operation cannot be performed with a running slave io thread; run STOP SLAVE IO_THREAD first.
     *
     * ER_SLAVE_IO_THREAD_MUST_STOP was added in 5.7.4, removed after 5.7.5.
     */
    const SLAVE_IO_THREAD_MUST_STOP = 1906;

    /**
     * File %s is corrupted
     */
    const FILE_CORRUPT = 3000;

    /**
     * Query partially completed on the master (error on master: %d) and was aborted. There is a chance that your master is inconsistent at this point. If you are sure that your master is ok, run this query manually on the slave and then restart the slave with SET GLOBAL SQL_SLAVE_SKIP_COUNTER=1; START SLAVE;. Query:'%s'
     */
    const ERROR_ON_MASTER = 3001;

    /**
     * Query caused different errors on master and slave. Error on master: message (format)='%s' error code=%d; Error on slave:actual message='%s', error code=%d. Default database:'%s'. Query:'%s'
     */
    const INCONSISTENT_ERROR = 3002;

    /**
     * Storage engine for table '%s'.'%s' is not loaded.
     */
    const STORAGE_ENGINE_NOT_LOADED = 3003;

    /**
     * GET STACKED DIAGNOSTICS when handler not active
     */
    const GET_STACKED_DA_WITHOUT_ACTIVE_HANDLER = 3004;

    /**
     * %s is no longer supported. The statement was converted to %s.
     */
    const WARN_LEGACY_SYNTAX_CONVERTED = 3005;

    /**
     * Statement is unsafe because it uses a fulltext parser plugin which may not return the same value on the slave.
     *
     * @since 5.7.1
     */
    const BINLOG_UNSAFE_FULLTEXT_PLUGIN = 3006;

    /**
     * Cannot DISCARD/IMPORT tablespace associated with temporary table
     *
     * @since 5.7.1
     */
    const CANNOT_DISCARD_TEMPORARY_TABLE = 3007;

    /**
     * Foreign key cascade delete/update exceeds max depth of %d.
     *
     * @since 5.7.2
     */
    const FK_DEPTH_EXCEEDED = 3008;

    /**
     * Column count of %s.%s is wrong. Expected %d, found %d. Created with MySQL %d, now running %d. Please use mysql_upgrade to fix this error.
     *
     * @since 5.7.2
     */
    const COL_COUNT_DOESNT_MATCH_PLEASE_UPDATE_V2 = 3009;

    /**
     * Trigger %s.%s.%s does not have CREATED attribute.
     *
     * @since 5.7.2
     */
    const WARN_TRIGGER_DOESNT_HAVE_CREATED = 3010;

    /**
     * Referenced trigger '%s' for the given action time and event type does not exist.
     *
     * @since 5.7.2
     */
    const REFERENCED_TRG_DOES_NOT_EXIST = 3011;

    /**
     * EXPLAIN FOR CONNECTION command is supported only for SELECT/UPDATE/INSERT/DELETE/REPLACE
     *
     * @since 5.7.2
     */
    const EXPLAIN_NOT_SUPPORTED = 3012;

    /**
     * Invalid size for column '%s'.
     *
     * @since 5.7.2
     */
    const INVALID_FIELD_SIZE = 3013;

    /**
     * Table storage engine '%s' found required create option missing
     *
     * @since 5.7.2
     */
    const MISSING_HA_CREATE_OPTION = 3014;

    /**
     * Out of memory in storage engine '%s'.
     *
     * @since 5.7.3
     */
    const ENGINE_OUT_OF_MEMORY = 3015;

    /**
     * The password for anonymous user cannot be expired.
     *
     * @since 5.7.3
     */
    const PASSWORD_EXPIRE_ANONYMOUS_USER = 3016;

    /**
     * This operation cannot be performed with a running slave sql thread; run STOP SLAVE SQL_THREAD first
     *
     * @since 5.7.3
     */
    const SLAVE_SQL_THREAD_MUST_STOP = 3017;

    /**
     * Cannot create FULLTEXT index on materialized subquery
     *
     * @since 5.7.4
     */
    const NO_FT_MATERIALIZED_SUBQUERY = 3018;

    /**
     * Undo Log error: %s
     *
     * @since 5.7.4
     */
    const INNODB_UNDO_LOG_FULL = 3019;

    /**
     * Invalid argument for logarithm
     *
     * @since 5.7.4
     */
    const INVALID_ARGUMENT_FOR_LOGARITHM = 3020;

    /**
     * This operation cannot be performed with a running slave io thread; run STOP SLAVE IO_THREAD FOR CHANNEL '%s' first.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_IO_THREAD_MUST_STOP = 3021;

    /**
     * This operation may not be safe when the slave has temporary tables. The tables will be kept open until the server restarts or until the tables are deleted by any replicated DROP statement. Suggest to wait until slave_open_temp_tables = 0.
     *
     * @since 5.7.4
     */
    const WARN_OPEN_TEMP_TABLES_MUST_BE_ZERO = 3022;

    /**
     * CHANGE MASTER TO with a MASTER_LOG_FILE clause but no MASTER_LOG_POS clause may not be safe. The old position value may not be valid for the new binary log file.
     *
     * @since 5.7.4
     */
    const WARN_ONLY_MASTER_LOG_FILE_NO_POS = 3023;

    /**
     * Query execution was interrupted, maximum statement execution time exceeded
     *
     * @since 5.7.4
     */
    const QUERY_TIMEOUT = 3024;

    /**
     * Select is not a read only statement, disabling timer
     *
     * @since 5.7.4
     */
    const NON_RO_SELECT_DISABLE_TIMER = 3025;

    /**
     * Duplicate entry '%s'.
     *
     * @since 5.7.4
     */
    const DUP_LIST_ENTRY = 3026;

    /**
     * '%s' mode no longer has any effect. Use STRICT_ALL_TABLES or STRICT_TRANS_TABLES instead.
     *
     * @since 5.7.4
     */
    const SQL_MODE_NO_EFFECT = 3027;

    /**
     * Expression #%u of ORDER BY contains aggregate function and applies to a UNION
     *
     * @since 5.7.5
     */
    const AGGREGATE_ORDER_FOR_UNION = 3028;

    /**
     * Expression #%u of ORDER BY contains aggregate function and applies to the result of a non-aggregated query
     *
     * @since 5.7.5
     */
    const AGGREGATE_ORDER_NON_AGG_QUERY = 3029;

    /**
     * Slave worker has stopped after at least one previous worker encountered an error when slave-preserve-commit-order was enabled. To preserve commit order, the last transaction executed by this thread has not been committed. When restarting the slave after fixing any failed threads, you should fix this worker as well.
     *
     * @since 5.7.5
     */
    const SLAVE_WORKER_STOPPED_PREVIOUS_THD_ERROR = 3030;

    /**
     * slave_preserve_commit_order is not supported %s.
     *
     * @since 5.7.5
     */
    const DONT_SUPPORT_SLAVE_PRESERVE_COMMIT_ORDER = 3031;

    /**
     * The server is currently in offline mode
     *
     * @since 5.7.5
     */
    const SERVER_OFFLINE_MODE = 3032;

    /**
     * Binary geometry function %s given two geometries of different srids: %u and %u, which should have been identical.
     *
     * Geometry values passed as arguments to spatial functions must have the same SRID value.
     *
     * @since 5.7.5
     */
    const GIS_DIFFERENT_SRIDS = 3033;

    /**
     * Calling geometry function %s with unsupported types of arguments.
     *
     * A spatial function was called with a combination of argument types that the function does not support.
     *
     * @since 5.7.5
     */
    const GIS_UNSUPPORTED_ARGUMENT = 3034;

    /**
     * Unknown GIS error occured in function %s.
     *
     * @since 5.7.5
     */
    const GIS_UNKNOWN_ERROR = 3035;

    /**
     * Unknown exception caught in GIS function %s.
     *
     * @since 5.7.5
     */
    const GIS_UNKNOWN_EXCEPTION = 3036;

    /**
     * Invalid GIS data provided to function %s.
     *
     * A spatial function was called with an argument not recognized as a valid geometry value.
     *
     * @since 5.7.5
     */
    const GIS_INVALID_DATA = 3037;

    /**
     * The geometry has no data in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_EMPTY_INPUT_EXCEPTION = 3038;

    /**
     * Unable to calculate centroid because geometry is empty in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_CENTROID_EXCEPTION = 3039;

    /**
     * Geometry overlay calculation error: geometry data is invalid in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_OVERLAY_INVALID_INPUT_EXCEPTION = 3040;

    /**
     * Geometry turn info calculation error: geometry data is invalid in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_TURN_INFO_EXCEPTION = 3041;

    /**
     * Analysis procedures of intersection points interrupted unexpectedly in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_SELF_INTERSECTION_POINT_EXCEPTION = 3042;

    /**
     * Unknown exception thrown in function %s.
     *
     * @since 5.7.5
     */
    const BOOST_GEOMETRY_UNKNOWN_EXCEPTION = 3043;

    /**
     * Memory allocation error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_BAD_ALLOC_ERROR = 3044;

    /**
     * Domain error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_DOMAIN_ERROR = 3045;

    /**
     * Length error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_LENGTH_ERROR = 3046;

    /**
     * Invalid argument error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_INVALID_ARGUMENT = 3047;

    /**
     * Out of range error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_OUT_OF_RANGE_ERROR = 3048;

    /**
     * Overflow error error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_OVERFLOW_ERROR = 3049;

    /**
     * Range error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_RANGE_ERROR = 3050;

    /**
     * Underflow error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_UNDERFLOW_ERROR = 3051;

    /**
     * Logic error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_LOGIC_ERROR = 3052;

    /**
     * Runtime error: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_RUNTIME_ERROR = 3053;

    /**
     * Unknown exception: %s in function %s.
     *
     * @since 5.7.5
     */
    const STD_UNKNOWN_EXCEPTION = 3054;

    /**
     * Geometry byte string must be little endian.
     *
     * @since 5.7.5
     */
    const GIS_DATA_WRONG_ENDIANESS = 3055;

    /**
     * The password provided for the replication user exceeds the maximum length of 32 characters
     *
     * @since 5.7.5
     */
    const CHANGE_MASTER_PASSWORD_LENGTH = 3056;

    /**
     * Incorrect user-level lock name '%s'.
     *
     * @since 5.7.5
     */
    const USER_LOCK_WRONG_NAME = 3057;

    /**
     * Deadlock found when trying to get user-level lock; try rolling back transaction/releasing locks and restarting lock acquisition.
     *
     * This error is returned when the metdata locking subsystem detects a deadlock for an attempt to acquire a named lock with GET_LOCK.
     *
     * @since 5.7.5
     */
    const USER_LOCK_DEADLOCK = 3058;

    /**
     * REPLACE cannot be executed as it requires deleting rows that are not in the view
     *
     * @since 5.7.5
     */
    const REPLACE_INACCESSIBLE_ROWS = 3059;

    /**
     * Do not support online operation on table with GIS index
     *
     * @since 5.7.5
     */
    const ALTER_OPERATION_NOT_SUPPORTED_REASON_GIS = 3060;

    /**
     * User variable name '%s' is illegal
     *
     * @since 5.7.5
     */
    const ILLEGAL_USER_VAR = 3061;

    /**
     * Cannot %s when GTID_MODE = OFF.
     *
     * @since 5.7.5
     */
    const GTID_MODE_OFF = 3062;

    /**
     * Cannot %s from a replication slave thread.
     *
     * @since 5.7.5
     */
    const UNSUPPORTED_BY_REPLICATION_THREAD = 3063;

    /**
     * Incorrect type for argument %s in function %s.
     *
     * @since 5.7.5
     */
    const INCORRECT_TYPE = 3064;

    /**
     * Expression #%u of ORDER BY clause is not in SELECT list, references column '%s' which is not in SELECT list; this is incompatible with %s
     *
     * @since 5.7.5
     */
    const FIELD_IN_ORDER_NOT_SELECT = 3065;

    /**
     * Expression #%u of ORDER BY clause is not in SELECT list, contains aggregate function; this is incompatible with %s
     *
     * @since 5.7.5
     */
    const AGGREGATE_IN_ORDER_NOT_SELECT = 3066;

    /**
     * Supplied filter list contains a value which is not in the required format 'db_pattern.table_pattern'
     *
     * @since 5.7.5
     */
    const INVALID_RPL_WILD_TABLE_FILTER_PATTERN = 3067;

    /**
     * OK packet too large
     *
     * @since 5.7.5
     */
    const NET_OK_PACKET_TOO_LARGE = 3068;

    /**
     * Invalid JSON data provided to function %s: %s
     *
     * @since 5.7.5
     */
    const INVALID_JSON_DATA = 3069;

    /**
     * Invalid GeoJSON data provided to function %s: Missing required member '%s'
     *
     * @since 5.7.5
     */
    const INVALID_GEOJSON_MISSING_MEMBER = 3070;

    /**
     * Invalid GeoJSON data provided to function %s: Member '%s' must be of type '%s'
     *
     * @since 5.7.5
     */
    const INVALID_GEOJSON_WRONG_TYPE = 3071;

    /**
     * Invalid GeoJSON data provided to function %s
     *
     * @since 5.7.5
     */
    const INVALID_GEOJSON_UNSPECIFIED = 3072;

    /**
     * Unsupported number of coordinate dimensions in function %s: Found %u, expected %u
     *
     * @since 5.7.5
     */
    const DIMENSION_UNSUPPORTED = 3073;

    /**
     * Slave channel '%s' does not exist.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_DOES_NOT_EXIST = 3074;

    /**
     * A slave channel '%s' already exists for the given host and port combination.
     *
     * @since 5.7.6
     */
    const SLAVE_MULTIPLE_CHANNELS_HOST_PORT = 3075;

    /**
     * Couldn't create channel: Channel name is either invalid or too long.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_NAME_INVALID_OR_TOO_LONG = 3076;

    /**
     * To have multiple channels, repository cannot be of type FILE; Please check the repository configuration and convert them to TABLE.
     *
     * @since 5.7.6
     */
    const SLAVE_NEW_CHANNEL_WRONG_REPOSITORY = 3077;

    /**
     * Cannot delete slave info objects for channel '%s'.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_DELETE = 3078;

    /**
     * Multiple channels exist on the slave. Please provide channel name as an argument.
     *
     * @since 5.7.6
     */
    const SLAVE_MULTIPLE_CHANNELS_CMD = 3079;

    /**
     * Maximum number of replication channels allowed exceeded.
     *
     * @since 5.7.6
     */
    const SLAVE_MAX_CHANNELS_EXCEEDED = 3080;

    /**
     * This operation cannot be performed with running replication threads; run STOP SLAVE FOR CHANNEL '%s' first
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_MUST_STOP = 3081;

    /**
     * This operation requires running replication threads; configure slave and run START SLAVE FOR CHANNEL '%s'
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_NOT_RUNNING = 3082;

    /**
     * Replication thread(s) for channel '%s' are already runnning.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_WAS_RUNNING = 3083;

    /**
     * Replication thread(s) for channel '%s' are already stopped.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_WAS_NOT_RUNNING = 3084;

    /**
     * This operation cannot be performed with a running slave sql thread; run STOP SLAVE SQL_THREAD FOR CHANNEL '%s' first.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_SQL_THREAD_MUST_STOP = 3085;

    /**
     * When sql_slave_skip_counter > 0, it is not allowed to start more than one SQL thread by using 'START SLAVE [SQL_THREAD]'. Value of sql_slave_skip_counter can only be used by one SQL thread at a time. Please use 'START SLAVE [SQL_THREAD] FOR CHANNEL' to start the SQL thread which will use the value of sql_slave_skip_counter.
     *
     * @since 5.7.6
     */
    const SLAVE_CHANNEL_SQL_SKIP_COUNTER = 3086;

    /**
     * Expression #%u of %s is not in GROUP BY clause and contains nonaggregated column '%s' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by
     *
     * @since 5.7.6
     */
    const WRONG_FIELD_WITH_GROUP_V2 = 3087;

    /**
     * In aggregated query without GROUP BY, expression #%u of %s contains nonaggregated column '%s'; this is incompatible with sql_mode=only_full_group_by
     *
     * @since 5.7.6
     */
    const MIX_OF_GROUP_FUNC_AND_FIELDS_V2 = 3088;

    /**
     * Updating '%s' is deprecated. It will be made read-only in a future release.
     *
     * @since 5.7.6
     */
    const WARN_DEPRECATED_SYSVAR_UPDATE = 3089;

    /**
     * Changing sql mode '%s' is deprecated. It will be removed in a future release.
     *
     * @since 5.7.6
     */
    const WARN_DEPRECATED_SQLMODE = 3090;

    /**
     * DROP DATABASE failed; some tables may have been dropped but the database directory remains. The GTID has not been added to GTID_EXECUTED and the statement was not written to the binary log. Fix this as follows: (1) remove all files from the database directory %s; (2) SET GTID_NEXT='%s'; (3) DROP DATABASE `%s`.
     *
     * @since 5.7.6
     */
    const CANNOT_LOG_PARTIAL_DROP_DATABASE_WITH_GTID = 3091;

    /**
     * The server is not configured properly to be an active member of the group. Please see more details on error log.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_CONFIGURATION = 3092;

    /**
     * The START GROUP_REPLICATION command failed since the group is already running.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_RUNNING = 3093;

    /**
     * The START GROUP_REPLICATION command failed as the applier module failed to start.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_APPLIER_INIT_ERROR = 3094;

    /**
     * The STOP GROUP_REPLICATION command execution is incomplete: The applier thread got the stop signal while it was busy. The applier thread will stop once the current task is complete.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_STOP_APPLIER_THREAD_TIMEOUT = 3095;

    /**
     * The START GROUP_REPLICATION command failed as there was an error when initializing the group communication layer.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_COMMUNICATION_LAYER_SESSION_ERROR = 3096;

    /**
     * The START GROUP_REPLICATION command failed as there was an error when joining the communication group.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const GROUP_REPLICATION_COMMUNICATION_LAYER_JOIN_ERROR = 3097;

    /**
     * The table does not comply with the requirements by an external plugin.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const BEFORE_DML_VALIDATION_ERROR = 3098;

    /**
     * Cannot change the value of variable %s without binary log format as ROW.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const PREVENTS_VARIABLE_WITHOUT_RBR = 3099;

    /**
     * Error on observer while running replication hook '%s'.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const RUN_HOOK_ERROR = 3100;

    /**
     * Plugin instructed the server to rollback the current transaction.
     *
     * This error is reserved for future use.
     *
     * @since 5.7.6
     */
    const TRANSACTION_ROLLBACK_DURING_COMMIT = 3101;

    /**
     * Expression of generated column '%s' contains a disallowed function.
     *
     * @since 5.7.6
     */
    const GENERATED_COLUMN_FUNCTION_IS_NOT_ALLOWED = 3102;

    /**
     * Key/Index cannot be defined on a virtual generated column.
     *
     * ER_KEY_BASED_ON_GENERATED_COLUMN was added in 5.7.6, removed after 5.7.7.
     */
    const KEY_BASED_ON_GENERATED_COLUMN = 3103;

    /**
     * INPLACE ADD or DROP of virtual columns cannot be combined with other ALTER TABLE actions
     *
     * @since 5.7.8
     */
    const UNSUPPORTED_ALTER_INPLACE_ON_VIRTUAL_COLUMN = 3103;

    /**
     * Cannot define foreign key with %s clause on a generated column.
     *
     * @since 5.7.6
     */
    const WRONG_FK_OPTION_FOR_GENERATED_COLUMN = 3104;

    /**
     * The value specified for generated column '%s' in table '%s' is not allowed.
     *
     * @since 5.7.6
     */
    const NON_DEFAULT_VALUE_FOR_GENERATED_COLUMN = 3105;

    /**
     * '%s' is not supported for generated columns.
     *
     * @since 5.7.6
     */
    const UNSUPPORTED_ACTION_ON_GENERATED_COLUMN = 3106;

    /**
     * Generated column can refer only to generated columns defined prior to it.
     *
     * To address this issue, change the table definition to define each generated column later than any generated columns to which it refers.
     *
     * @since 5.7.6
     */
    const GENERATED_COLUMN_NON_PRIOR = 3107;

    /**
     * Column '%s' has a generated column dependency.
     *
     * You cannot drop or rename a generated column if another column refers to it. You must either drop those columns as well, or redefine them not to refer to the generated column.
     *
     * @since 5.7.6
     */
    const DEPENDENT_BY_GENERATED_COLUMN = 3108;

    /**
     * Generated column '%s' cannot refer to auto-increment column.
     *
     * @since 5.7.6
     */
    const GENERATED_COLUMN_REF_AUTO_INC = 3109;

    /**
     * The '%s' feature is not available; you need to remove '%s' or use MySQL built with '%s'
     *
     * @since 5.7.6
     */
    const FEATURE_NOT_AVAILABLE = 3110;

    /**
     * SET @@GLOBAL.GTID_MODE = %s is not allowed because %s.
     *
     * @since 5.7.6
     */
    const CANT_SET_GTID_MODE = 3111;

    /**
     * The replication receiver thread%s cannot start in AUTO_POSITION mode: this server uses @@GLOBAL.GTID_MODE = OFF.
     *
     * @since 5.7.6
     */
    const CANT_USE_AUTO_POSITION_WITH_GTID_MODE_OFF = 3112;

    /**
     * Cannot replicate anonymous transaction when AUTO_POSITION = 1, at file %s, position %lld.
     *
     * @since 5.7.6
     */
    const CANT_REPLICATE_ANONYMOUS_WITH_AUTO_POSITION = 3113;

    /**
     * Cannot replicate anonymous transaction when @@GLOBAL.GTID_MODE = ON, at file %s, position %lld.
     *
     * @since 5.7.6
     */
    const CANT_REPLICATE_ANONYMOUS_WITH_GTID_MODE_ON = 3114;

    /**
     * Cannot replicate GTID-transaction when @@GLOBAL.GTID_MODE = OFF, at file %s, position %lld.
     *
     * @since 5.7.6
     */
    const CANT_REPLICATE_GTID_WITH_GTID_MODE_OFF = 3115;

    /**
     * Cannot set ENFORCE_GTID_CONSISTENCY = ON because there are ongoing transactions that violate GTID consistency.
     *
     * ER_CANT_SET_ENFORCE_GTID_CONSISTENCY_ON_WITH_ONGOING_GTID_VIOLATING_TRANSACTIONS is renamed to ER_CANT_ENFORCE_GTID_CONSISTENCY_WITH_ONGOING_GTID_VIOLATING_TX in MySQL 8.0.
     *
     * @since 5.7.6
     */
    const CANT_SET_ENFORCE_GTID_CONSISTENCY_ON_WITH_ONGOING_GTID_VIOLATING_TRANSACTIONS = 3116;

    /**
     * There are ongoing transactions that violate GTID consistency.
     *
     * ER_SET_ENFORCE_GTID_CONSISTENCY_WARN_WITH_ONGOING_GTID_VIOLATING_TRANSACTIONS is renamed to ER_ENFORCE_GTID_CONSISTENCY_WARN_WITH_ONGOING_GTID_VIOLATING_TX in MySQL 8.0.
     *
     * @since 5.7.6
     */
    const SET_ENFORCE_GTID_CONSISTENCY_WARN_WITH_ONGOING_GTID_VIOLATING_TRANSACTIONS = 3117;

    /**
     * Access denied for user '%s'@'%s'. Account is locked.
     *
     * The account was locked with CREATE USER ... ACCOUNT LOCK or ALTER USER ... ACCOUNT LOCK. An administrator can unlock it with ALTER USER ... ACCOUNT UNLOCK.
     *
     * @since 5.7.6
     */
    const ACCOUNT_HAS_BEEN_LOCKED = 3118;

    /**
     * Incorrect tablespace name `%s`
     *
     * @since 5.7.6
     */
    const WRONG_TABLESPACE_NAME = 3119;

    /**
     * Tablespace `%s` is not empty.
     *
     * @since 5.7.6
     */
    const TABLESPACE_IS_NOT_EMPTY = 3120;

    /**
     * Incorrect File Name '%s'.
     *
     * @since 5.7.6
     */
    const WRONG_FILE_NAME = 3121;

    /**
     * Inconsistent intersection points.
     *
     * @since 5.7.7
     */
    const BOOST_GEOMETRY_INCONSISTENT_TURNS_EXCEPTION = 3122;

    /**
     * Optimizer hint syntax error
     *
     * @since 5.7.7
     */
    const WARN_OPTIMIZER_HINT_SYNTAX_ERROR = 3123;

    /**
     * Unsupported MAX_EXECUTION_TIME
     *
     * @since 5.7.7
     */
    const WARN_BAD_MAX_EXECUTION_TIME = 3124;

    /**
     * MAX_EXECUTION_TIME hint is supported by top-level standalone SELECT statements only
     *
     * The MAX_EXECUTION_TIME() optimizer hint is supported only for SELECT statements.
     *
     * @since 5.7.7
     */
    const WARN_UNSUPPORTED_MAX_EXECUTION_TIME = 3125;

    /**
     * Hint %s is ignored as conflicting/duplicated
     *
     * @since 5.7.7
     */
    const WARN_CONFLICTING_HINT = 3126;

    /**
     * Query block name %s is not found for %s hint
     *
     * @since 5.7.7
     */
    const WARN_UNKNOWN_QB_NAME = 3127;

    /**
     * Unresolved name %s for %s hint
     *
     * @since 5.7.7
     */
    const UNRESOLVED_HINT_NAME = 3128;

    /**
     * Unsetting sql mode '%s' is deprecated. It will be made read-only in a future release.
     *
     * ER_WARN_DEPRECATED_SQLMODE_UNSET was added in 5.7.7, removed after 5.7.7.
     */
    const WARN_DEPRECATED_SQLMODE_UNSET = 3129;

    /**
     * Please do not modify the %s table. This is a mysql internal system table to store GTIDs for committed transactions. Modifying it can lead to an inconsistent GTID state.
     *
     * @since 5.7.8
     */
    const WARN_ON_MODIFYING_GTID_EXECUTED_TABLE = 3129;

    /**
     * Command not supported by pluggable protocols
     *
     * @since 5.7.8
     */
    const PLUGGABLE_PROTOCOL_COMMAND_NOT_SUPPORTED = 3130;

    /**
     * Incorrect locking service lock name '%s'.
     *
     * A locking service name was specified as NULL, the empty string, or a string longer than 64 characters. Namespace and lock names must be non-NULL, nonempty, and no more than 64 characters long.
     *
     * @since 5.7.8
     */
    const LOCKING_SERVICE_WRONG_NAME = 3131;

    /**
     * Deadlock found when trying to get locking service lock; try releasing locks and restarting lock acquisition.
     *
     * @since 5.7.8
     */
    const LOCKING_SERVICE_DEADLOCK = 3132;

    /**
     * Service lock wait timeout exceeded.
     *
     * @since 5.7.8
     */
    const LOCKING_SERVICE_TIMEOUT = 3133;

    /**
     * Parameter %s exceeds the maximum number of points in a geometry (%lu) in function %s.
     *
     * @since 5.7.8
     */
    const GIS_MAX_POINTS_IN_GEOMETRY_OVERFLOWED = 3134;

    /**
     * 'NO_ZERO_DATE', 'NO_ZERO_IN_DATE' and 'ERROR_FOR_DIVISION_BY_ZERO' sql modes should be used with strict mode. They will be merged with strict mode in a future release.
     *
     * @since 5.7.8
     */
    const SQL_MODE_MERGED = 3135;

    /**
     * Version token mismatch for %.*s. Correct value %.*s
     *
     * The client has set its version_tokens_session system variable to the list of tokens it requires the server to match, but the server token list has at least one matching token name that has a value different from what the client requires. See Section 6.5.6, “Version Tokens”.
     *
     * @since 5.7.8
     */
    const VTOKEN_PLUGIN_TOKEN_MISMATCH = 3136;

    /**
     * Version token %.*s not found.
     *
     * The client has set its version_tokens_session system variable to the list of tokens it requires the server to match, but the server token list is missing at least one of those tokens. See Section 6.5.6, “Version Tokens”.
     *
     * @since 5.7.8
     */
    const VTOKEN_PLUGIN_TOKEN_NOT_FOUND = 3137;

    /**
     * Variable %s cannot be changed by a client that owns a GTID. The client owns %s. Ownership is released on COMMIT or ROLLBACK.
     *
     * @since 5.7.8
     */
    const CANT_SET_VARIABLE_WHEN_OWNING_GTID = 3138;

    /**
     * %s cannot be performed on channel '%s'.
     *
     * @since 5.7.8
     */
    const SLAVE_CHANNEL_OPERATION_NOT_ALLOWED = 3139;

    /**
     * Invalid JSON text: "%s" at position %u in value for column '%s'.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_TEXT = 3140;

    /**
     * Invalid JSON text in argument %u to function %s: "%s" at position %u.%s
     *
     * @since 5.7.8
     */
    const INVALID_JSON_TEXT_IN_PARAM = 3141;

    /**
     * The JSON binary value contains invalid data.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_BINARY_DATA = 3142;

    /**
     * Invalid JSON path expression. The error is around character position %u.%s
     *
     * @since 5.7.8
     */
    const INVALID_JSON_PATH = 3143;

    /**
     * Cannot create a JSON value from a string with CHARACTER SET '%s'.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_CHARSET = 3144;

    /**
     * Invalid JSON character data provided to function %s: '%s'; utf8 is required.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_CHARSET_IN_FUNCTION = 3145;

    /**
     * Invalid data type for JSON data in argument %u to function %s; a JSON string or JSON type is required.
     *
     * @since 5.7.8
     */
    const INVALID_TYPE_FOR_JSON = 3146;

    /**
     * Cannot CAST value to JSON.
     *
     * @since 5.7.8
     */
    const INVALID_CAST_TO_JSON = 3147;

    /**
     * A path expression must be encoded in the utf8 character set. The path expression '%s' is encoded in character set '%s'.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_PATH_CHARSET = 3148;

    /**
     * In this situation, path expressions may not contain the * and ** tokens.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_PATH_WILDCARD = 3149;

    /**
     * The JSON value is too big to be stored in a JSON column.
     *
     * @since 5.7.8
     */
    const JSON_VALUE_TOO_BIG = 3150;

    /**
     * The JSON object contains a key name that is too long.
     *
     * @since 5.7.8
     */
    const JSON_KEY_TOO_BIG = 3151;

    /**
     * JSON column '%s' cannot be used in key specification.
     *
     * @since 5.7.8
     */
    const JSON_USED_AS_KEY = 3152;

    /**
     * The path expression '$' is not allowed in this context.
     *
     * @since 5.7.8
     */
    const JSON_VACUOUS_PATH = 3153;

    /**
     * The oneOrAll argument to %s may take these values: 'one' or 'all'.
     *
     * @since 5.7.8
     */
    const JSON_BAD_ONE_OR_ALL_ARG = 3154;

    /**
     * Out of range JSON value for CAST to %s%s from column %s at row %ld
     *
     * @since 5.7.8
     */
    const NUMERIC_JSON_VALUE_OUT_OF_RANGE = 3155;

    /**
     * Invalid JSON value for CAST to %s%s from column %s at row %ld
     *
     * @since 5.7.8
     */
    const INVALID_JSON_VALUE_FOR_CAST = 3156;

    /**
     * The JSON document exceeds the maximum depth.
     *
     * @since 5.7.8
     */
    const JSON_DOCUMENT_TOO_DEEP = 3157;

    /**
     * JSON documents may not contain NULL member names.
     *
     * @since 5.7.8
     */
    const JSON_DOCUMENT_NULL_KEY = 3158;

    /**
     * Connections using insecure transport are prohibited while --require_secure_transport=ON.
     *
     * With the require_secure_transport system variable, clients can connect only using secure transports. Qualifying connections are those using SSL, a Unix socket file, or shared memory.
     *
     * @since 5.7.8
     */
    const SECURE_TRANSPORT_REQUIRED = 3159;

    /**
     * No secure transports (SSL or Shared Memory) are configured, unable to set --require_secure_transport=ON.
     *
     * The require_secure_transport system variable cannot be enabled if the server does not support at least one secure transport. Configure the server with the required SSL keys/certificates to enable SSL connections, or enable the shared_memory system variable to enable shared-memory connections.
     *
     * @since 5.7.8
     */
    const NO_SECURE_TRANSPORTS_CONFIGURED = 3160;

    /**
     * Storage engine %s is disabled (Table creation is disallowed).
     *
     * An attempt was made to create a table or tablespace using a storage engine listed in the value of the disabled_storage_engines system variable, or to change an existing table or tablespace to such an engine. Choose a different storage engine.
     *
     * @since 5.7.8
     */
    const DISABLED_STORAGE_ENGINE = 3161;

    /**
     * User %s does not exist.
     *
     * @since 5.7.8
     */
    const USER_DOES_NOT_EXIST = 3162;

    /**
     * User %s already exists.
     *
     * @since 5.7.8
     */
    const USER_ALREADY_EXISTS = 3163;

    /**
     * Aborted by Audit API ('%s';%d).
     *
     * This error indicates that an audit plugin terminated execution of an event. The message typically indicates the event subclass name and a numeric status value.
     *
     * @since 5.7.8
     */
    const AUDIT_API_ABORT = 3164;

    /**
     * A path expression is not a path to a cell in an array.
     *
     * @since 5.7.8
     */
    const INVALID_JSON_PATH_ARRAY_CELL = 3165;

    /**
     * Another buffer pool resize is already in progress.
     *
     * @since 5.7.9
     */
    const BUFPOOL_RESIZE_INPROGRESS = 3166;

    /**
     * The '%s' feature is disabled; see the documentation for '%s'
     *
     * @since 5.7.9
     */
    const FEATURE_DISABLED_SEE_DOC = 3167;

    /**
     * Server isn't available
     *
     * @since 5.7.9
     */
    const SERVER_ISNT_AVAILABLE = 3168;

    /**
     * Session was killed
     *
     * @since 5.7.9
     */
    const SESSION_WAS_KILLED = 3169;

    /**
     * Memory capacity of %llu bytes for '%s' exceeded. %s
     *
     * @since 5.7.9
     */
    const CAPACITY_EXCEEDED = 3170;

    /**
     * Range optimization was not done for this query.
     *
     * @since 5.7.9
     */
    const CAPACITY_EXCEEDED_IN_RANGE_OPTIMIZER = 3171;

    /**
     * Partitioning upgrade required. Please dump/reload to fix it or do: ALTER TABLE `%s`.`%s` UPGRADE PARTITIONING
     *
     * @since 5.7.9
     */
    const TABLE_NEEDS_UPG_PART = 3172;

    /**
     * The client holds ownership of the GTID %s. Therefore, WAIT_FOR_EXECUTED_GTID_SET cannot wait for this GTID.
     *
     * @since 5.7.9
     */
    const CANT_WAIT_FOR_EXECUTED_GTID_SET_WHILE_OWNING_A_GTID = 3173;

    /**
     * Cannot add foreign key on the base column of indexed virtual column.
     *
     * @since 5.7.10
     */
    const CANNOT_ADD_FOREIGN_BASE_COL_VIRTUAL = 3174;

    /**
     * Cannot create index on virtual column whose base column has foreign constraint.
     *
     * @since 5.7.10
     */
    const CANNOT_CREATE_VIRTUAL_INDEX_CONSTRAINT = 3175;

    /**
     * Please do not modify the %s table with an XA transaction. This is an internal system table used to store GTIDs for committed transactions. Although modifying it can lead to an inconsistent GTID state, if neccessary you can modify it with a non-XA transaction.
     *
     * @since 5.7.11
     */
    const ERROR_ON_MODIFYING_GTID_EXECUTED_TABLE = 3176;

    /**
     * Lock acquisition refused by storage engine.
     *
     * @since 5.7.11
     */
    const LOCK_REFUSED_BY_ENGINE = 3177;

    /**
     * ADD COLUMN col...VIRTUAL, ADD INDEX(col)
     *
     * @since 5.7.11
     */
    const UNSUPPORTED_ALTER_ONLINE_ON_VIRTUAL_COLUMN = 3178;

    /**
     * Master key rotation is not supported by storage engine.
     *
     * @since 5.7.11
     */
    const MASTER_KEY_ROTATION_NOT_SUPPORTED_BY_SE = 3179;

    /**
     * Encryption key rotation error reported by SE: %s
     *
     * @since 5.7.11
     */
    const MASTER_KEY_ROTATION_ERROR_BY_SE = 3180;

    /**
     * Write to binlog failed. However, master key rotation has been completed successfully.
     *
     * @since 5.7.11
     */
    const MASTER_KEY_ROTATION_BINLOG_FAILED = 3181;

    /**
     * Storage engine is not available.
     *
     * @since 5.7.11
     */
    const MASTER_KEY_ROTATION_SE_UNAVAILABLE = 3182;

    /**
     * This tablespace can't be encrypted.
     *
     * @since 5.7.11
     */
    const TABLESPACE_CANNOT_ENCRYPT = 3183;

    /**
     * Invalid encryption option.
     *
     * @since 5.7.11
     */
    const INVALID_ENCRYPTION_OPTION = 3184;

    /**
     * Can't find master key from keyring, please check keyring plugin is loaded.
     *
     * @since 5.7.11
     */
    const CANNOT_FIND_KEY_IN_KEYRING = 3185;

    /**
     * Parser bailed out for this query.
     *
     * @since 5.7.12
     */
    const CAPACITY_EXCEEDED_IN_PARSER = 3186;

    /**
     * Cannot alter encryption attribute by inplace algorithm.
     *
     * @since 5.7.13
     */
    const UNSUPPORTED_ALTER_ENCRYPTION_INPLACE = 3187;

    /**
     * Function '%s' failed because underlying keyring service returned an error. Please check if a keyring plugin is installed and that provided arguments are valid for the keyring you are using.
     *
     * @since 5.7.13
     */
    const KEYRING_UDF_KEYRING_SERVICE_ERROR = 3188;

    /**
     * It seems that your db schema is old. The %s column is 77 characters long and should be 93 characters long. Please run mysql_upgrade.
     *
     * @since 5.7.13
     */
    const USER_COLUMN_OLD_LENGTH = 3189;

    /**
     * RESET MASTER is not allowed because %s.
     *
     * @since 5.7.14
     */
    const CANT_RESET_MASTER = 3190;

    /**
     * The START GROUP_REPLICATION command failed since the group already has 9 members.
     *
     * @since 5.7.14
     */
    const GROUP_REPLICATION_MAX_GROUP_SIZE = 3191;

    /**
     * Cannot add foreign key on the base column of stored column.
     *
     * @since 5.7.14
     */
    const CANNOT_ADD_FOREIGN_BASE_COL_STORED = 3192;

    /**
     * Cannot complete the operation because table is referenced by another connection.
     *
     * @since 5.7.14
     */
    const TABLE_REFERENCED = 3193;
}