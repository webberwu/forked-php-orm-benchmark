<?php
namespace AuthorBooks\Model;
require_once __DIR__ . '/AuthorSchemaProxy.php';
use Maghead\Schema\SchemaLoader;
use Maghead\Result;
use Maghead\Inflator;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use Maghead\BaseRepo;
class AuthorRepo
    extends BaseRepo
{
    const SCHEMA_CLASS = 'AuthorBooks\\Model\\AuthorSchema';
    const SCHEMA_PROXY_CLASS = 'AuthorBooks\\Model\\AuthorSchemaProxy';
    const COLLECTION_CLASS = 'AuthorBooks\\Model\\AuthorCollection';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Author';
    const TABLE = 'author';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    const TABLE_ALIAS = 'm';
    const FIND_BY_PRIMARY_KEY_SQL = 'SELECT * FROM author WHERE id = ? LIMIT 1';
    const DELETE_BY_PRIMARY_KEY_SQL = 'DELETE FROM author WHERE id = ?';
    public static $columnNames = array (
      0 => 'id',
      1 => 'name',
      2 => 'email',
      3 => 'identity',
      4 => 'confirmed',
      5 => 'created_on',
      6 => 'updated_on',
    );
    public static $columnHash = array (
      'id' => 1,
      'name' => 1,
      'email' => 1,
      'identity' => 1,
      'confirmed' => 1,
      'created_on' => 1,
      'updated_on' => 1,
    );
    public static $mixinClasses = array (
      0 => 'Maghead\\Schema\\Mixin\\MetadataMixinSchema',
    );
    protected $table = 'author';
    protected $findStm;
    protected $deleteStm;
    protected $findByNameStm;
    protected $findByEmailStm;
    protected $findByIdentityStm;
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\AuthorSchemaProxy;
    }
    public function find($pkId)
    {
        if (!$this->findStm) {
           $this->findStm = $this->read->prepare(self::FIND_BY_PRIMARY_KEY_SQL);
           $this->findStm->setFetchMode(PDO::FETCH_CLASS, 'AuthorBooks\Model\Author');
        }
        return static::_stmFetch($this->findStm, [$pkId]);
    }
    public function findByName($value)
    {
        if (!isset($this->findByNameStm)) {
            $this->findByNameStm = $this->read->prepare('SELECT * FROM author WHERE name = :name LIMIT 1');
            $this->findByNameStm->setFetchMode(PDO::FETCH_CLASS, \AuthorBooks\Model\Author);
        }
        return static::_stmFetch($this->findByNameStm, [':name' => $value ]);
    }
    public function findByEmail($value)
    {
        if (!isset($this->findByEmailStm)) {
            $this->findByEmailStm = $this->read->prepare('SELECT * FROM author WHERE email = :email LIMIT 1');
            $this->findByEmailStm->setFetchMode(PDO::FETCH_CLASS, \AuthorBooks\Model\Author);
        }
        return static::_stmFetch($this->findByEmailStm, [':email' => $value ]);
    }
    public function findByIdentity($value)
    {
        if (!isset($this->findByIdentityStm)) {
            $this->findByIdentityStm = $this->read->prepare('SELECT * FROM author WHERE identity = :identity LIMIT 1');
            $this->findByIdentityStm->setFetchMode(PDO::FETCH_CLASS, \AuthorBooks\Model\Author);
        }
        return static::_stmFetch($this->findByIdentityStm, [':identity' => $value ]);
    }
    public function deleteByPrimaryKey($pkId)
    {
        if (!$this->deleteStm) {
           $this->deleteStm = $this->write->prepare(self::DELETE_BY_PRIMARY_KEY_SQL);
        }
        return $this->deleteStm->execute([$pkId]);
    }
}
