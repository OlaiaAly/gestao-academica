<?php
namespace MyApp\model\classes;
use \PDO;

class Database{
    
    const HOST = 'localhost';
    const DBNAME = 'assiduidade';
    const USER = 'root';
    const PASSWORD = '';

    private $table;
    private $connection;

    /**
     * Metodo contrutor da classse db
     * @param $table tudo acontence nas tabelas em sql
     */
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

        /**
     * Metodo responsavel pela definicao da connexao usando PDO
     */
    private function setConnection(){
        try{
            //$conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
            $this->connection = new PDO('mysql:host='.self::HOST.'; dbname='.self::DBNAME, self::USER, self::PASSWORD);
            /**
             * em caso de erro em uma query trave o processo!
             */
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOEXEPTION $e){
            //die('ERRO'.$e.getMessage());
        }
    }
    
    /**
     * Metodo responsavel por executar querys dentro do BD
     * @param string  $query
     * @param  string $params, pode ir vasio quando e {SELECT} e com parametros quando eh {INSERT, DELECT} 
     * @return PDOStatement 
     *  */  
    public function execute($query, $params = []){
        try{
            $stmt = $this->connection->prepare($query);// ele ainda nao sabe com que valores substituir
            $stmt->execute($params);// metodo do PDO para executar querys
            return $stmt;
        }
        catch(PDOEXEPTION $e){
            //die('ERRO'.$e.getMessage());
        }
    }


        
    /**
     * metodo para insercao de dados no BD
     * @param arrays do tipo [fiel =>values]
     * @return integer retorna o id
     *  */    
    public function insert($values){
        //@function array_keys('vector') retorna um novo, transformando as chaves em valor
        $fields = array_keys($values);
        /**
         * @function array_pad('[]', 'size', 'padrao') retorna um array com tamanho definiddo
         * caso o posicao esteeja vasia ele atribui o padrao 
         */
        $binds = array_pad([], count($fields), '?');

        //@function implode('separador', 'vector'), concantena os valores do vector com o separador escolhido
        $query = 'INSERT INTO  '.$this->table.' ('.implode(',', $fields).')  VALUES ('.implode(',', $binds).')';
        
        //executa o query
        $this->execute($query, array_values($values)); //@function array_values($values) retorn os valores do vector em forma de string
        
        //retorna o ultimo id inserido
        return $this->connection->lastInsertId();
    } 

    
    
    /**
     * Metodo responsalvel pela consulta  no banco
     * @return PDOStamtent
     */
    function select($where = null, $order = null,  $fields = ' * ', $limit = null ){
        //Preparando a query
            $where = strlen($where) ? ' WHERE '.$where : '';
            $order = strlen($order) ? ' ORDER '.$order : ''; 
            $limit = strlen($limit) ? ' LIMIT '.$limit : ''; 
        //Fim do preparo
            $query = 'SELECT '.$fields.' FROM '.$this->table.''.$where.''.$order.''.$limit.'';
    
            return $this->execute($query);// returs PDOSTATMENT
        }

        
    /**
     * Metodo responsavel por actualizar os compos
     * 
     */
    public function update($where, $values){
        // preparando query
        //@function array_keys('vector') transforma as chaves em  um vector de valor
        $fields = array_keys($values);

        //@function implode('separador', 'vector'), concantena os valores do vector com o separador escolhido
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? where '.$where;

        echo"<pre>"; print_r($query); echo"</pre>"; exit;

       // $this->execute($query, array_values($values));

        return true;
    }

    /**
     * Metodo responsavel por 
     * @param $where que leva o id;
     *@return boolean
     */
    public function delete($where){
        $query = ' DELETE FROM '.$this->table.' where '.$where; 

        $this->execute($query);
        return true;
    }
}


