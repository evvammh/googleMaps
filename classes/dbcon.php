<?
/*-------------------------------------------------------------------------------
|| Name: dbcon.php																||
|| Purpose: custom mysql functions			 									||
|| Source: custom																||
|| Where Use: Entire Website													||
|| Modified: 25/06/2008															||
--------------------------------------------------------------------------------*/
class dbcon
{
	var $Con, $Res, $PAGE_SIZE, $numrows, $currentpage, $count;
/*-------------------------------------------------------------------------------
|| Name: dbcon																	||
|| Purpose: for database connectivity											||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/	
	function dbcon()
	{
		global $DB_NAME, $DB_USER, $DB_PASSWORD, $DB_HOST;
		$this->Con=mysql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
		mysql_select_db($DB_NAME,$this->Con);
	}

/*-------------------------------------------------------------------------------
|| Name: fieldname																||
|| Purpose: to get fieldname													||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/	
	function fieldname()
	{
		$arr=array();
		for($i=0;$i<mysql_num_fields($this->Res);$i++)
		$arr[$i]=mysql_field_name($this->Res,$i);
		return $arr;
	}

/*-------------------------------------------------------------------------------
|| Name: Query																||
|| Purpose: to execute a query													||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/	
	function Query($SQL,$PAGE='n')
	{
		global $PAGESIZE;
		$this->Res=mysql_query($SQL) or die("Error: ".$SQL."<BR>".mysql_error($this->Con));
		$this->numrows=$this->NumRow();
		$this->count=0;
		if($PAGE=='n')
		{
			$this->PAGE_SIZE= $this->numrows;
		}
		else
		{	
			$this->PAGE_SIZE=(is_int($PAGE) ? $PAGE : $PAGESIZE);
			$this->currentpage=($_GET["currentpage"])=='' ? 1 : $_GET["currentpage"];
			$pos=($this->currentpage-1)*$this->PAGE_SIZE;
			if($this->numrows>0)
			@mysql_data_seek($this->Res,$pos);
		}	 
	}

/*-------------------------------------------------------------------------------
|| Name: mysql_exec_batch														||
|| Purpose: to execute batch query												||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/	
	function mysql_exec_batch ($p_query, $p_transaction_safe = true)
	{
  		if ($p_transaction_safe)
		{
      		$p_query = 'START TRANSACTION;' . $p_query . '; COMMIT;';
    	}
  		
		$query_split = preg_split ("/[;]+/", $p_query);
  		foreach ($query_split as $command_line)
		{
    		$command_line = trim($command_line);
    		if ($command_line != '')
			{
      			$this->Query($command_line);
			}
  		}
  	}

/*-------------------------------------------------------------------------------
|| Name: PageNavigation															||
|| Purpose: page navigation 													||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/	
	function PageNavigation($qstr='')
	{
		if($this->numrows>0)
		$pagecount=ceil($this->numrows/$this->PAGE_SIZE);
		else
		$pagecount=0;
		
		//$p_nav='<b>Page:</b> ';
		
		if($pagecount>=1)
		{
			if($this->currentpage>1)
			$p_nav .=" <a href=\"$_SERVER[PHP_SELF]?currentpage=1".($qstr!='' ? "&$qstr" : "")."\">&laquo;</a> <a href=\"$_SERVER[PHP_SELF]?currentpage=".($this->currentpage-1).($qstr!='' ? "&$qstr" : "")."\">&#8249;</a> ";
			else
			$p_nav .=' &laquo; &#8249; ';
		}	
		
		if($this->currentpage%10==0)
		$start=$this->currentpage-9;
		else
		$start=($this->currentpage-($this->currentpage%10))+1;
		
		$i=$start;
		while($i<($start+10) && $i<=$pagecount)
		{
			if($i==$this->currentpage)
			$p_nav .=" <b>$i</b> ";
			else
			$p_nav .=" <a href=\"$_SERVER[PHP_SELF]?currentpage=$i".($qstr!='' ? "&$qstr" : "")."\">$i</a> ";
			
			$i++;
		}
		
		if($pagecount>=1)
		{
			if($this->currentpage<$pagecount)
			$p_nav .=" <a href=\"$_SERVER[PHP_SELF]?currentpage=".($this->currentpage+1).($qstr!='' ? "&$qstr" : "")."\">&#8250;</a> <a href=\"$_SERVER[PHP_SELF]?currentpage=$pagecount".($qstr!='' ? "&$qstr" : "")."\">&raquo;</a> ";
			else
			$p_nav .=' &#8250; &raquo; ';
		}	
		
		if($this->numrows==0)
		return "";
		else
		return "<span class=\"noprint\">$p_nav Displaying ".((($this->currentpage*$this->PAGE_SIZE)-$this->PAGE_SIZE)+1)." - ".((($this->currentpage*$this->PAGE_SIZE)-$this->PAGE_SIZE)+($this->currentpage==$pagecount ? ($this->numrows==$this->PAGE_SIZE ? $this->numrows : ceil($this->numrows%$this->PAGE_SIZE)) : $this->PAGE_SIZE))." of ".$this->NumRow()."</span>"; 
	}
/*-------------------------------------------------------------------------------
|| Name: NumRow																	||
|| Purpose: to return number of rows											||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function NumRow()
	{
		return(@mysql_num_rows($this->Res));
	}

/*-------------------------------------------------------------------------------
|| Name: FetchRow																||
|| Purpose: to fetch rows														||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function FetchRow()
	{
		$this->count=$this->count+1;
		if($this->count>$this->PAGE_SIZE)
		return false;
		
		if($rs=mysql_fetch_array($this->Res))
		return($rs);
		else
		return false;
	}

/*-------------------------------------------------------------------------------
|| Name: FetchAssoc																||
|| Purpose: to fetch result row as an associative array							||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function FetchAssoc()
	{
		$this->count=$this->count+1;
		if($this->count>$this->PAGE_SIZE)
		return false;
		
		if($rs=mysql_fetch_assoc($this->Res))
		return($rs);
		else
		return false;
	}

/*-------------------------------------------------------------------------------
|| Name: InsertId																||
|| Purpose: to get last inserted id												||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function InsertId()
	{
		return(mysql_insert_id($this->Con));
	}

/*-------------------------------------------------------------------------------
|| Name: __destruct																||
|| Purpose: class destructor													||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function __destruct()
	{
		//mysql_free_result($this->Res);
		//mysql_close($this->Con);
	}

/*-------------------------------------------------------------------------------
|| Name: data_seek																||
|| Purpose: to move internal result pointer										||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/		
	function data_seek($pos)
	{
		@mysql_data_seek($this->Res,$pos);
	}
}
?>