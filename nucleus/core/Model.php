<?php
//use phpFastCache\CacheManager;

  class Model{

    protected static $_table;

    private static $_action;

    private static $_where = "";

    private static $_orderBy = "";

    private static $_limit = "";

    private static $_query = "";

    private static $_instance = null;

    private static $_fields = "*";

    private static $_params = [];

    public function __construct(){

        self::$_table = $this->table;

        self::$_instance = DB::getInstance();

    }

    public static function table($table){

      self::$_table = $table;

      return new static;

    }

    // Begging of Actioners
    public static function get(){ // done

      new static;

      self::$_query = "SELECT " . self::$_fields . " FROM " . self::$_table . " " . self::$_where . " " . self::$_orderBy . " " . self::$_limit;

      return self::$_instance->query(self::$_query, self::$_params)->results();

    }

    public static function update($data = []){ // done

      $set = '';

      $i = 1;

      foreach($data as $name => $value){

        $set .= "$name = ?";

        $set .= ($i < count($data)) ? ', ' : '';

        $i++;

      }


      $sql = "UPDATE " . self::$_table . " SET $set " . self::$_where;

      self::$_params = array_merge($data, self::$_params);

      if(!self::$_instance->query($sql, self::$_params)->error()){

        return true; // lastInsertedId

      }

    }

    public static function delete(){ // done

      new static;

      self::$_query = "DELETE FROM " . self::$_table . " " . self::$_where;

      return ( self::$_instance->query(self::$_query, self::$_params) ) ? true : false;

    }

    public static function create($data = []){ // done

      new static;

      if(count($data)){

        $keys = array_keys($data);

        $values = "";

        $i = 1;

        foreach($data as $field){

          $values .= '?';

          $values .= ($i < count($data)) ? ', ' : '';

          $i++;

        }

        $sql = "INSERT INTO " . self::$_table . " (`" . implode('`, `', $keys) . "`) VALUES ($values)";

        if(!self::$_instance->query($sql, $data)->error()){

          return true; // lastInsertedId

        }

      }

    }
    // End of Actioners

    // Beginning Query Modifiers
    public static function orderBy($field = "id", $direction = "ASC"){ // done

      self::$_orderBy = " ORDER BY $field $direction";

      return new static;

    }

    public static function limit($amount, $begining = 0){ // done

      self::$_limit = "LIMIT $begining, $amount";

      return new static;

    }

    private static function whereExists(){ // done

      self::$_where .= (strlen(self::$_where) == 0) ? " WHERE " : "";

      $temp = (self::$_where != " WHERE ") ? " AND " : "";

      self::$_where .= $temp;

      // if the last param

    }

    public static function where($column, $first ,$second = null){ // done

      $operator = ( in_array($first,['LIKE','=','>','<','!=']) ) ? $first : "=";

      $value = $second ?: $first;

      self::whereExists();

      self::$_where .= " $column $operator ? ";

      self::$_params[] = $value;

       return new static;

    }

    public static function orWhere($column, $first ,$second = null){ // done

      $operator = ( in_array($first,['LIKE','=','>','<','!=']) ) ? $first : "=";

      $value = $second ?: $first;

      self::$_where .= " OR $column $operator ? ";

      self::$_params[] = $value;

       return new static;

    }

    public static function whereBetween($column,$range){

      self::whereExists();

      self::$_where .= " $column BETWEEN ? AND ? ";

      self::$_params[] = array_merge(self::$_params,$range);

      return new static;

    }

    public static function whereIn($column,$data){

      self::whereExists();

      self::$data = Neutron::stringify($data);

			$bind = "";

			foreach($data as $tmp){

				$bind .= '?,';

			}

			$bind = substr($bind,0,strlen($bind)-1);

      self::$_where .= " $column IN ($bind)";

      self::$_params[] = array_merge(self::$_params,$data);

      return new static;

    }

    public static function field($fields){ // done

      self::$_fields = Neutron::stringify($fields);

      return new static;

    }

    public static function distinct($fields){ // done

      self::$_fields = "DISTINCT " .  Neutron::stringify($fields);

      return new static;

    }
    // end of Qery modifiers

    public static function join($otherTable,$mainTableField, $otherTableField){

      self::$_table = self::$_table . " JOIN $otherTable ON " . self::$_table . ".$mainTableField = $otherTable.$otherTableField";

      return new static;

    }

    // Beginning of Cache
  	public function setupCahceInstance(){

  		if(self::$_CACHEINSTANCEISSET == null){

  			CacheManager::setup([]);

  			CacheManager::CachingMethod("phpfastcache");

  			$this->_cacheInstance = CacheManager::Files();

  			self::$_CACHEINSTANCEISSET = true;

  		}

  	}

  	public function deleteCacheKey($key){

  		$key = str_replace(" ", "", strtolower($key));

  		// echo " deleting $key";

  		$this->setupCahceInstance();

  		$this->_cacheInstance->delete($key);

  		return $this;

  	}

  	public function getAndCache($table, $field, $where, $key, $duration = 600){

  		$key = str_replace(" ", "", strtolower($key));

  		$time = microtime();
  		//echo "[$key]";

  		$this->setupCahceInstance();

  		$data = $this->_cacheInstance->get($key);

  		if(is_null($data)) {
  		//	echo "First query";
  			$data = $this->action('SELECT ' . $field, $table, $where)->results();

  			$this->_cacheInstance->set($key, $data, $duration);

  			$this->_cachedResults = $data;

  		} else {

  			// echo "Cached Query";

  			$this->_cachedResults = $data;

  		}

  		//echo "(" . (microtime() - $time) * 10 . ")";

  		return $this;

  	}

  	public function cachedResults(){

  		return $this->_cachedResults;

  	}

  	public function cachedFirst(){

  		return $this->_cachedResults[0];

  	}
    // End of cache

    // others -> fast track
    public static function paginate(){

      $page = (isset($_GET['page'])) ? $_GET['page'] : 1;

	     $totalContent = "kk";// this count

    }

	  public static function searchAble(){

        //sds

	  }

    public static function updateId ($id,$data){ // done

        new static;

        self::$_where = " WHERE id = ? ";

        self::$_params[] = $id;

        return self::update($data);

      }

    public static function terminate ($id){ // done

        new static;

        self::$_where = "WHERE id = ? ";

        self::$_params[] = $id;

        return self::delete();


      }
    // end of fast track

    // Start of $query callers
    public static function first($field = "id"){ // done

      self::$_limit = "LIMIT 1";

      self::$_orderBy = "ORDER BY $field ASC";

      $results = self::get();

      return $results[0];

    }

    public static function last($field = "id"){ // done

      self::$_limit = "LIMIT 1";

      self::$_orderBy = "ORDER BY $field DESC";

      $results = self::get();

      return $results[0];

    }

    public static function sum($field){ // done

      self::$_fields = "SUM($field) AS sum";

      $results = self::get();

      return $results[0]->sum;

    }

    public static function avg($field){ // done

      self::$_fields = "AVG($field) AS avg";

      $results = self::get();

      return $results[0]->avg;

    }

    public static function max($field){ // done

      self::$_fields = "MAX($field) AS max";

      $results = self::get();

      return $results[0]->max;

    }

    public static function min($field){ // done

      self::$_fields = "MIN($field) AS min";

      $results = self::get();

      return $results[0]->min;

    }

    public static function count($field = "*"){

      self::$_fields = "count($field) AS count";

      $results = self::get();

      return $results[0]->count;

    }
    // End of query Callers

}


?>
