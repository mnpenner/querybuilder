<?php namespace QueryBuilder\Connections;

use PDO;
use QueryBuilder\Interfaces\IStatement;

class PdoMySqlConnection extends AbstractMySqlConnection {
    use PdoParamTrait;
    
    /** @var PDO */
    private $pdo;
    /** @var string */
    private $charset;

    /**
     * PdoMySqlConnection constructor.
     * @param PDO $pdo
     * @param string|null $charset Connection charset. Must be set correctly to avoid injection. Set to `null` to query the current charset.
     */
    function __construct(PDO $pdo, $charset=null) {
        $this->pdo = $pdo;

        // It's kind of dangerous to store this because technically you can change the charset after the connection is made via `SET NAMES` but who would do that?
        if(strlen($charset)) {
            $this->charset = $charset;
        } else {
            $this->charset = $pdo->query("SELECT CHARSET('')")->fetchColumn();
        }
        if($this->charset === 'utf8mb4') {
            $this->charset = 'utf8';
        }
    }

    /**
     * Quotes a string for use in a query.
     *
     * CAUTION:
     * The character set must be set either on the server level, or within the database connection itself (depending on the driver) for it to affect this method. See the driver-specific documentation for more information.
     *
     * @param string $string The string to be quoted.
     * @param array &$ctx
     * @return string A quoted string that is theoretically safe to pass into an SQL statement. Returns FALSE if the driver does not support quoting in this way.
     * @internal param int $paramType Provides a data type hint for drivers that have alternate quoting styles.
     */
    protected function quoteString($string, array &$ctx) {
        return $this->pdo->quote($string);
    }


    /**
     * Prepares a statement for execution and returns a statement object
     *
     * Prepares an SQL statement to be executed by the PDOStatement::execute() method. The SQL statement can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be substituted when the statement is executed. You cannot use both named and question mark parameter markers within the same SQL statement; pick one or the other parameter style. Use these parameters to bind any user-input, do not include the user-input directly in the query.
     *
     * You must include a unique parameter marker for each value you wish to pass in to the statement when you call PDOStatement::execute(). You cannot use a named parameter marker of the same name more than once in a prepared statement, unless emulation mode is on.
     *
     * Calling PDO::prepare() and PDOStatement::execute() for statements that will be issued multiple times with different parameter values optimizes the performance of your application by allowing the driver to negotiate client and/or server side caching of the query plan and meta information, and helps to prevent SQL injection attacks by eliminating the need to manually quote the parameters.
     *
     * PDO will emulate prepared statements/bound parameters for drivers that do not natively support them, and can also rewrite named or question mark style parameter markers to something more appropriate, if the driver supports one style but not the other.
     *
     * @param IStatement $stmt Statement to be rendered and prepared
     * @param array $driver_options This array holds one or more key=>value pairs to set attribute values for the PDOStatement object that this method returns. You would most commonly use this to set the PDO::ATTR_CURSOR value to PDO::CURSOR_SCROLL to request a scrollable cursor. Some drivers have driver specific options that may be set at prepare-time.
     * @return \PDOStatement
     */
    public function prepare(IStatement $stmt, $driver_options=[]) {
        return $this->pdo->prepare($this->render($stmt), $driver_options);
    }

    public function getCharset() {
        return $this->charset;
    }
}