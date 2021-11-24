<?php
namespace MyApp\model\classes;
use \MyApp\model\classes\Database;
use \PDO;

class Docente{

    /** 
     * Definindo o nome da tabela, já que trabalhamos  em POO
     * */ 
    CONST TABLE = 'docente';
    
    /**
     * o id da tabela
     */
    public $id;
    
    /**
     * nome do docente
     */
    public $nome;

    /**
     * apelido do aluno
     */
    public $apelido;

    /**
     * periodo isto é laborar/pos-laboral em SQL usamos enum(L,P) onde L = laboral e P = Pos-Laboral
     */
    public $periodo;


    /**
     * sexo é um ENUM(M,F,O) onde M = masculino, F = femenino e O = outros
     */
    public $sexo;


 
    /**
     * Construtor da classe funcionario
     */

    public function cadastrar(){
        /**
         * cria connexao com o banco de dados e define a tabela a ser manipulada
        */
        $conn = new Database(self::TABLE);

        /**
         * @function insert retorna o id do registo atribuido no BD
         * Dedefinindo os data para tabela vaga, usasndo o tipo chave-valor
         */
        $this->nr_estudante = $conn->insert(
            [
                'id' => $this->id,
                'nome' => $this->nome,
                'apelido' => $this->apelido,
                'periodo' => $this->periodo,
                'sexo'=> $this->sexo
            ]
        );
        
       
        return true;
    }

    /**
     * Responsavel por pegar todos  funcionarios no banco de dados
     *@return array retorna um Array PDO
     */

    public static function getAllAluno($where = null, $order = null, $field ='*', $limit = null ){
        // definindo o fetch para trabalhar com classes e usando o self:class para dizer que quer usar a classe funcionario
        return (new Database(self::TABLE))->select($where, $order, $field, $limit)
                ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Metodo responsavel por buscar apenas um unico pelo id;
     *@return retorna um array do tipo PDO
     */
    public static function getAlunoById($nr_estudante){
        return (new Database(self::TABLE))->select(' id = '.$id)
            ->fetchObject(self::class);

    }


    /**
     * Metodo responsavel por actualizar vagas
     * @return bool
     */
    public function actualizar(){
        return (new Database(self::TABLE))->update(' id = '.$this->id,
                                                                        [
                                                                            'id' => $this->id,
                                                                            'nome' => $this->nome,
                                                                            'apelido' => $this->apelido,
                                                                            'periodo' => $this->periodo,
                                                                            'sexo'=> $this->sexo
                                                                        ]
                );
    }

    /**
     * Metodo para exclucao da vaga
     * @return bool
     */
    public function excluir(){
        return (new Database(self::TABLE))->delete('id ='.$this->nr_estudante);
    }



}