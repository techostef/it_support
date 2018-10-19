<?php

// Global variable for table object
$ticket_support = NULL;

//
// Table class for ticket_support
//
class cticket_support extends cTable {
	var $id;
	var $id_karyawan;
	var $judul;
	var $kendala;
	var $date_create_at;
	var $status_progress;
	var $id_karyawan_pemroses;
	var $keterangan;
	var $date_diproses;
	var $na;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'ticket_support';
		$this->TableName = 'ticket_support';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`ticket_support`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);
		$this->BasicSearch->TypeDefault = "OR";

		// id
		$this->id = new cField('ticket_support', 'ticket_support', 'x_id', 'id', '`id`', '`id`', 20, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_karyawan
		$this->id_karyawan = new cField('ticket_support', 'ticket_support', 'x_id_karyawan', 'id_karyawan', '`id_karyawan`', '`id_karyawan`', 20, -1, FALSE, '`id_karyawan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_karyawan->Sortable = TRUE; // Allow sort
		$this->id_karyawan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_karyawan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_karyawan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_karyawan'] = &$this->id_karyawan;

		// judul
		$this->judul = new cField('ticket_support', 'ticket_support', 'x_judul', 'judul', '`judul`', '`judul`', 200, -1, FALSE, '`judul`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->judul->Sortable = TRUE; // Allow sort
		$this->fields['judul'] = &$this->judul;

		// kendala
		$this->kendala = new cField('ticket_support', 'ticket_support', 'x_kendala', 'kendala', '`kendala`', '`kendala`', 201, -1, FALSE, '`kendala`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->kendala->Sortable = TRUE; // Allow sort
		$this->fields['kendala'] = &$this->kendala;

		// date_create_at
		$this->date_create_at = new cField('ticket_support', 'ticket_support', 'x_date_create_at', 'date_create_at', '`date_create_at`', ew_CastDateFieldForLike('`date_create_at`', 1, "DB"), 135, 1, FALSE, '`date_create_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date_create_at->Sortable = TRUE; // Allow sort
		$this->date_create_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['date_create_at'] = &$this->date_create_at;

		// status_progress
		$this->status_progress = new cField('ticket_support', 'ticket_support', 'x_status_progress', 'status_progress', '`status_progress`', '`status_progress`', 200, -1, FALSE, '`status_progress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status_progress->Sortable = TRUE; // Allow sort
		$this->status_progress->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status_progress->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status_progress->OptionCount = 3;
		$this->fields['status_progress'] = &$this->status_progress;

		// id_karyawan_pemroses
		$this->id_karyawan_pemroses = new cField('ticket_support', 'ticket_support', 'x_id_karyawan_pemroses', 'id_karyawan_pemroses', '`id_karyawan_pemroses`', '`id_karyawan_pemroses`', 20, -1, FALSE, '`id_karyawan_pemroses`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_karyawan_pemroses->Sortable = TRUE; // Allow sort
		$this->id_karyawan_pemroses->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_karyawan_pemroses->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_karyawan_pemroses->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_karyawan_pemroses'] = &$this->id_karyawan_pemroses;

		// keterangan
		$this->keterangan = new cField('ticket_support', 'ticket_support', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// date_diproses
		$this->date_diproses = new cField('ticket_support', 'ticket_support', 'x_date_diproses', 'date_diproses', '`date_diproses`', ew_CastDateFieldForLike('`date_diproses`', 1, "DB"), 135, 1, FALSE, '`date_diproses`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date_diproses->Sortable = TRUE; // Allow sort
		$this->date_diproses->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['date_diproses'] = &$this->date_diproses;

		// na
		$this->na = new cField('ticket_support', 'ticket_support', 'x_na', 'na', '`na`', '`na`', 202, -1, FALSE, '`na`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->na->Sortable = TRUE; // Allow sort
		$this->na->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->na->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->na->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->na->TrueValue = 'Y';
		$this->na->FalseValue = 'N';
		$this->na->OptionCount = 2;
		$this->fields['na'] = &$this->na;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`ticket_support`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = inTicketKaryawan();
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "ticket_supportlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ticket_supportview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ticket_supportedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ticket_supportadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "ticket_supportlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ticket_supportview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ticket_supportview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ticket_supportadd.php?" . $this->UrlParm($parm);
		else
			$url = "ticket_supportadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ticket_supportedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ticket_supportadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ticket_supportdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->id_karyawan->setDbValue($rs->fields('id_karyawan'));
		$this->judul->setDbValue($rs->fields('judul'));
		$this->kendala->setDbValue($rs->fields('kendala'));
		$this->date_create_at->setDbValue($rs->fields('date_create_at'));
		$this->status_progress->setDbValue($rs->fields('status_progress'));
		$this->id_karyawan_pemroses->setDbValue($rs->fields('id_karyawan_pemroses'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->date_diproses->setDbValue($rs->fields('date_diproses'));
		$this->na->setDbValue($rs->fields('na'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// id_karyawan
		// judul
		// kendala
		// date_create_at
		// status_progress
		// id_karyawan_pemroses
		// keterangan
		// date_diproses
		// na
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_karyawan
		if (strval($this->id_karyawan->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_karyawan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `karyawan`";
		$sWhereWrk = "";
		$this->id_karyawan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_karyawan, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_karyawan->ViewValue = $this->id_karyawan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_karyawan->ViewValue = $this->id_karyawan->CurrentValue;
			}
		} else {
			$this->id_karyawan->ViewValue = NULL;
		}
		$this->id_karyawan->ViewCustomAttributes = "";

		// judul
		$this->judul->ViewValue = $this->judul->CurrentValue;
		$this->judul->ViewCustomAttributes = "";

		// kendala
		$this->kendala->ViewValue = $this->kendala->CurrentValue;
		$this->kendala->ViewCustomAttributes = "";

		// date_create_at
		$this->date_create_at->ViewValue = $this->date_create_at->CurrentValue;
		$this->date_create_at->ViewValue = ew_FormatDateTime($this->date_create_at->ViewValue, 1);
		$this->date_create_at->ViewCustomAttributes = "";

		// status_progress
		if (strval($this->status_progress->CurrentValue) <> "") {
			$this->status_progress->ViewValue = $this->status_progress->OptionCaption($this->status_progress->CurrentValue);
		} else {
			$this->status_progress->ViewValue = NULL;
		}
		$this->status_progress->ViewCustomAttributes = "";

		// id_karyawan_pemroses
		if (strval($this->id_karyawan_pemroses->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_karyawan_pemroses->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `karyawan`";
		$sWhereWrk = "";
		$this->id_karyawan_pemroses->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_karyawan_pemroses, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_karyawan_pemroses->ViewValue = $this->id_karyawan_pemroses->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_karyawan_pemroses->ViewValue = $this->id_karyawan_pemroses->CurrentValue;
			}
		} else {
			$this->id_karyawan_pemroses->ViewValue = NULL;
		}
		$this->id_karyawan_pemroses->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// date_diproses
		$this->date_diproses->ViewValue = $this->date_diproses->CurrentValue;
		$this->date_diproses->ViewValue = ew_FormatDateTime($this->date_diproses->ViewValue, 1);
		$this->date_diproses->ViewCustomAttributes = "";

		// na
		if (ew_ConvertToBool($this->na->CurrentValue)) {
			$this->na->ViewValue = $this->na->FldTagCaption(1) <> "" ? $this->na->FldTagCaption(1) : "Tidak";
		} else {
			$this->na->ViewValue = $this->na->FldTagCaption(2) <> "" ? $this->na->FldTagCaption(2) : "YA";
		}
		$this->na->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_karyawan
		$this->id_karyawan->LinkCustomAttributes = "";
		$this->id_karyawan->HrefValue = "";
		$this->id_karyawan->TooltipValue = "";

		// judul
		$this->judul->LinkCustomAttributes = "";
		$this->judul->HrefValue = "";
		$this->judul->TooltipValue = "";

		// kendala
		$this->kendala->LinkCustomAttributes = "";
		$this->kendala->HrefValue = "";
		$this->kendala->TooltipValue = "";

		// date_create_at
		$this->date_create_at->LinkCustomAttributes = "";
		$this->date_create_at->HrefValue = "";
		$this->date_create_at->TooltipValue = "";

		// status_progress
		$this->status_progress->LinkCustomAttributes = "";
		$this->status_progress->HrefValue = "";
		$this->status_progress->TooltipValue = "";

		// id_karyawan_pemroses
		$this->id_karyawan_pemroses->LinkCustomAttributes = "";
		$this->id_karyawan_pemroses->HrefValue = "";
		$this->id_karyawan_pemroses->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// date_diproses
		$this->date_diproses->LinkCustomAttributes = "";
		$this->date_diproses->HrefValue = "";
		$this->date_diproses->TooltipValue = "";

		// na
		$this->na->LinkCustomAttributes = "";
		$this->na->HrefValue = "";
		$this->na->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_karyawan
		$this->id_karyawan->EditAttrs["class"] = "form-control";
		$this->id_karyawan->EditCustomAttributes = "readonly disabled";

		// judul
		$this->judul->EditAttrs["class"] = "form-control";
		$this->judul->EditCustomAttributes = "readonly disabled";
		$this->judul->EditValue = $this->judul->CurrentValue;
		$this->judul->PlaceHolder = ew_RemoveHtml($this->judul->FldCaption());

		// kendala
		$this->kendala->EditAttrs["class"] = "form-control";
		$this->kendala->EditCustomAttributes = "readonly disabled";
		$this->kendala->EditValue = $this->kendala->CurrentValue;
		$this->kendala->PlaceHolder = ew_RemoveHtml($this->kendala->FldCaption());

		// date_create_at
		$this->date_create_at->EditAttrs["class"] = "form-control";
		$this->date_create_at->EditCustomAttributes = "readonly disabled";
		$this->date_create_at->EditValue = ew_FormatDateTime($this->date_create_at->CurrentValue, 8);
		$this->date_create_at->PlaceHolder = ew_RemoveHtml($this->date_create_at->FldCaption());

		// status_progress
		$this->status_progress->EditAttrs["class"] = "form-control";
		$this->status_progress->EditCustomAttributes = "";
		$this->status_progress->EditValue = $this->status_progress->Options(TRUE);

		// id_karyawan_pemroses
		$this->id_karyawan_pemroses->EditAttrs["class"] = "form-control";
		$this->id_karyawan_pemroses->EditCustomAttributes = "";

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// date_diproses
		$this->date_diproses->EditAttrs["class"] = "form-control";
		$this->date_diproses->EditCustomAttributes = "";
		$this->date_diproses->EditValue = ew_FormatDateTime($this->date_diproses->CurrentValue, 8);
		$this->date_diproses->PlaceHolder = ew_RemoveHtml($this->date_diproses->FldCaption());

		// na
		$this->na->EditAttrs["class"] = "form-control";
		$this->na->EditCustomAttributes = "";
		$this->na->EditValue = $this->na->Options(TRUE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id_karyawan->Exportable) $Doc->ExportCaption($this->id_karyawan);
					if ($this->judul->Exportable) $Doc->ExportCaption($this->judul);
					if ($this->kendala->Exportable) $Doc->ExportCaption($this->kendala);
					if ($this->date_create_at->Exportable) $Doc->ExportCaption($this->date_create_at);
					if ($this->status_progress->Exportable) $Doc->ExportCaption($this->status_progress);
					if ($this->id_karyawan_pemroses->Exportable) $Doc->ExportCaption($this->id_karyawan_pemroses);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->date_diproses->Exportable) $Doc->ExportCaption($this->date_diproses);
					if ($this->na->Exportable) $Doc->ExportCaption($this->na);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id_karyawan->Exportable) $Doc->ExportCaption($this->id_karyawan);
					if ($this->judul->Exportable) $Doc->ExportCaption($this->judul);
					if ($this->date_create_at->Exportable) $Doc->ExportCaption($this->date_create_at);
					if ($this->status_progress->Exportable) $Doc->ExportCaption($this->status_progress);
					if ($this->id_karyawan_pemroses->Exportable) $Doc->ExportCaption($this->id_karyawan_pemroses);
					if ($this->date_diproses->Exportable) $Doc->ExportCaption($this->date_diproses);
					if ($this->na->Exportable) $Doc->ExportCaption($this->na);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id_karyawan->Exportable) $Doc->ExportField($this->id_karyawan);
						if ($this->judul->Exportable) $Doc->ExportField($this->judul);
						if ($this->kendala->Exportable) $Doc->ExportField($this->kendala);
						if ($this->date_create_at->Exportable) $Doc->ExportField($this->date_create_at);
						if ($this->status_progress->Exportable) $Doc->ExportField($this->status_progress);
						if ($this->id_karyawan_pemroses->Exportable) $Doc->ExportField($this->id_karyawan_pemroses);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->date_diproses->Exportable) $Doc->ExportField($this->date_diproses);
						if ($this->na->Exportable) $Doc->ExportField($this->na);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id_karyawan->Exportable) $Doc->ExportField($this->id_karyawan);
						if ($this->judul->Exportable) $Doc->ExportField($this->judul);
						if ($this->date_create_at->Exportable) $Doc->ExportField($this->date_create_at);
						if ($this->status_progress->Exportable) $Doc->ExportField($this->status_progress);
						if ($this->id_karyawan_pemroses->Exportable) $Doc->ExportField($this->id_karyawan_pemroses);
						if ($this->date_diproses->Exportable) $Doc->ExportField($this->date_diproses);
						if ($this->na->Exportable) $Doc->ExportField($this->na);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {
			$id = $rsnew['id'];
			$date = date("Y-m-d H:i:s");
			$id_karyawan = getIdUser();
			$query = "UPDATE `ticket_support` SET `id_karyawan`='$id_karyawan',`status_progress`='Menunggu Antrian',`date_create_at`='$date'";
			$query.= " where id='$id' ";
			ew_Execute($query);

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {
		// Enter your code here
		// To cancel, set return value to FALSE
		$rsnew['id_karyawan'] = $rsold['id_karyawan'];
		$rsnew['judul'] = $rsold['judul'];
		$rsnew['kendala'] = $rsold['kendala'];
		$rsnew['date_create_at'] = $rsold['date_create_at'];
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {
		//echo "Row Updated";
		$id = $rsold['id'];
		$date = date("Y-m-d H:i:s");
		$id_karyawan = getIdUser();
		$query = "UPDATE `ticket_support` SET  `id_karyawan_pemroses`='$id_karyawan',`date_diproses`='$date'";
		$query.= " where id='$id' ";
		ew_Execute($query);
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
