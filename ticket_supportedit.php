<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ticket_supportinfo.php" ?>
<?php include_once "karyawaninfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$ticket_support_edit = NULL; // Initialize page object first

class cticket_support_edit extends cticket_support {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}';

	// Table name
	var $TableName = 'ticket_support';

	// Page object name
	var $PageObjName = 'ticket_support_edit';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (ticket_support)
		if (!isset($GLOBALS["ticket_support"]) || get_class($GLOBALS["ticket_support"]) == "cticket_support") {
			$GLOBALS["ticket_support"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ticket_support"];
		}

		// Table object (karyawan)
		if (!isset($GLOBALS['karyawan'])) $GLOBALS['karyawan'] = new ckaryawan();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ticket_support', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (karyawan)
		if (!isset($UserTable)) {
			$UserTable = new ckaryawan();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ticket_supportlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_karyawan->SetVisibility();
		$this->judul->SetVisibility();
		$this->kendala->SetVisibility();
		$this->date_create_at->SetVisibility();
		$this->status_progress->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->na->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $ticket_support;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ticket_support);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "ticket_supportview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("ticket_supportlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "ticket_supportlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_karyawan->FldIsDetailKey) {
			$this->id_karyawan->setFormValue($objForm->GetValue("x_id_karyawan"));
		}
		if (!$this->judul->FldIsDetailKey) {
			$this->judul->setFormValue($objForm->GetValue("x_judul"));
		}
		if (!$this->kendala->FldIsDetailKey) {
			$this->kendala->setFormValue($objForm->GetValue("x_kendala"));
		}
		if (!$this->date_create_at->FldIsDetailKey) {
			$this->date_create_at->setFormValue($objForm->GetValue("x_date_create_at"));
			$this->date_create_at->CurrentValue = ew_UnFormatDateTime($this->date_create_at->CurrentValue, 1);
		}
		if (!$this->status_progress->FldIsDetailKey) {
			$this->status_progress->setFormValue($objForm->GetValue("x_status_progress"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->na->FldIsDetailKey) {
			$this->na->setFormValue($objForm->GetValue("x_na"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->id_karyawan->CurrentValue = $this->id_karyawan->FormValue;
		$this->judul->CurrentValue = $this->judul->FormValue;
		$this->kendala->CurrentValue = $this->kendala->FormValue;
		$this->date_create_at->CurrentValue = $this->date_create_at->FormValue;
		$this->date_create_at->CurrentValue = ew_UnFormatDateTime($this->date_create_at->CurrentValue, 1);
		$this->status_progress->CurrentValue = $this->status_progress->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->na->CurrentValue = $this->na->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->id_karyawan->setDbValue($row['id_karyawan']);
		$this->judul->setDbValue($row['judul']);
		$this->kendala->setDbValue($row['kendala']);
		$this->date_create_at->setDbValue($row['date_create_at']);
		$this->status_progress->setDbValue($row['status_progress']);
		$this->id_karyawan_pemroses->setDbValue($row['id_karyawan_pemroses']);
		$this->keterangan->setDbValue($row['keterangan']);
		$this->date_diproses->setDbValue($row['date_diproses']);
		$this->na->setDbValue($row['na']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['id_karyawan'] = NULL;
		$row['judul'] = NULL;
		$row['kendala'] = NULL;
		$row['date_create_at'] = NULL;
		$row['status_progress'] = NULL;
		$row['id_karyawan_pemroses'] = NULL;
		$row['keterangan'] = NULL;
		$row['date_diproses'] = NULL;
		$row['na'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_karyawan->DbValue = $row['id_karyawan'];
		$this->judul->DbValue = $row['judul'];
		$this->kendala->DbValue = $row['kendala'];
		$this->date_create_at->DbValue = $row['date_create_at'];
		$this->status_progress->DbValue = $row['status_progress'];
		$this->id_karyawan_pemroses->DbValue = $row['id_karyawan_pemroses'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->date_diproses->DbValue = $row['date_diproses'];
		$this->na->DbValue = $row['na'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		$this->id_karyawan->ViewCustomAttributes = ['class'=>'check0'];

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
		$this->id_karyawan_pemroses->ViewCustomAttributes = ['class'=>'check0'];

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

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// na
			$this->na->LinkCustomAttributes = "";
			$this->na->HrefValue = "";
			$this->na->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id_karyawan
			$this->id_karyawan->EditAttrs["class"] = "form-control";
			$this->id_karyawan->EditCustomAttributes = "readonly disabled";
			if (trim(strval($this->id_karyawan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_karyawan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `karyawan`";
			$sWhereWrk = "";
			$this->id_karyawan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_karyawan, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_karyawan->EditValue = $arwrk;

			// judul
			$this->judul->EditAttrs["class"] = "form-control";
			$this->judul->EditCustomAttributes = "readonly disabled";
			$this->judul->EditValue = ew_HtmlEncode($this->judul->CurrentValue);
			$this->judul->PlaceHolder = ew_RemoveHtml($this->judul->FldCaption());

			// kendala
			$this->kendala->EditAttrs["class"] = "form-control";
			$this->kendala->EditCustomAttributes = "readonly disabled";
			$this->kendala->EditValue = ew_HtmlEncode($this->kendala->CurrentValue);
			$this->kendala->PlaceHolder = ew_RemoveHtml($this->kendala->FldCaption());

			// date_create_at
			$this->date_create_at->EditAttrs["class"] = "form-control";
			$this->date_create_at->EditCustomAttributes = "readonly disabled";
			$this->date_create_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_create_at->CurrentValue, 8));
			$this->date_create_at->PlaceHolder = ew_RemoveHtml($this->date_create_at->FldCaption());

			// status_progress
			$this->status_progress->EditAttrs["class"] = "form-control";
			$this->status_progress->EditCustomAttributes = "";
			$this->status_progress->EditValue = $this->status_progress->Options(TRUE);

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// na
			$this->na->EditAttrs["class"] = "form-control";
			$this->na->EditCustomAttributes = "";
			$this->na->EditValue = $this->na->Options(TRUE);

			// Edit refer script
			// id_karyawan

			$this->id_karyawan->LinkCustomAttributes = "";
			$this->id_karyawan->HrefValue = "";

			// judul
			$this->judul->LinkCustomAttributes = "";
			$this->judul->HrefValue = "";

			// kendala
			$this->kendala->LinkCustomAttributes = "";
			$this->kendala->HrefValue = "";

			// date_create_at
			$this->date_create_at->LinkCustomAttributes = "";
			$this->date_create_at->HrefValue = "";

			// status_progress
			$this->status_progress->LinkCustomAttributes = "";
			$this->status_progress->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// na
			$this->na->LinkCustomAttributes = "";
			$this->na->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->id_karyawan->FldIsDetailKey && !is_null($this->id_karyawan->FormValue) && $this->id_karyawan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_karyawan->FldCaption(), $this->id_karyawan->ReqErrMsg));
		}
		if (!$this->judul->FldIsDetailKey && !is_null($this->judul->FormValue) && $this->judul->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->judul->FldCaption(), $this->judul->ReqErrMsg));
		}
		if (!$this->kendala->FldIsDetailKey && !is_null($this->kendala->FormValue) && $this->kendala->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kendala->FldCaption(), $this->kendala->ReqErrMsg));
		}
		if (!$this->date_create_at->FldIsDetailKey && !is_null($this->date_create_at->FormValue) && $this->date_create_at->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_create_at->FldCaption(), $this->date_create_at->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->date_create_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_create_at->FldErrMsg());
		}
		if (!$this->status_progress->FldIsDetailKey && !is_null($this->status_progress->FormValue) && $this->status_progress->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status_progress->FldCaption(), $this->status_progress->ReqErrMsg));
		}
		if (!$this->keterangan->FldIsDetailKey && !is_null($this->keterangan->FormValue) && $this->keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keterangan->FldCaption(), $this->keterangan->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// id_karyawan
			$this->id_karyawan->SetDbValueDef($rsnew, $this->id_karyawan->CurrentValue, NULL, $this->id_karyawan->ReadOnly);

			// judul
			$this->judul->SetDbValueDef($rsnew, $this->judul->CurrentValue, "", $this->judul->ReadOnly);

			// kendala
			$this->kendala->SetDbValueDef($rsnew, $this->kendala->CurrentValue, "", $this->kendala->ReadOnly);

			// date_create_at
			$this->date_create_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_create_at->CurrentValue, 1), NULL, $this->date_create_at->ReadOnly);

			// status_progress
			$this->status_progress->SetDbValueDef($rsnew, $this->status_progress->CurrentValue, NULL, $this->status_progress->ReadOnly);

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, $this->keterangan->ReadOnly);

			// na
			$this->na->SetDbValueDef($rsnew, ((strval($this->na->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->na->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ticket_supportlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_id_karyawan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `karyawan`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_karyawan, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ticket_support_edit)) $ticket_support_edit = new cticket_support_edit();

// Page init
$ticket_support_edit->Page_Init();

// Page main
$ticket_support_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ticket_support_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fticket_supportedit = new ew_Form("fticket_supportedit", "edit");

// Validate form
fticket_supportedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_id_karyawan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->id_karyawan->FldCaption(), $ticket_support->id_karyawan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_judul");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->judul->FldCaption(), $ticket_support->judul->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kendala");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->kendala->FldCaption(), $ticket_support->kendala->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_create_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->date_create_at->FldCaption(), $ticket_support->date_create_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_create_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ticket_support->date_create_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_progress");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->status_progress->FldCaption(), $ticket_support->status_progress->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ticket_support->keterangan->FldCaption(), $ticket_support->keterangan->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fticket_supportedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fticket_supportedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fticket_supportedit.Lists["x_id_karyawan"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"karyawan"};
fticket_supportedit.Lists["x_id_karyawan"].Data = "<?php echo $ticket_support_edit->id_karyawan->LookupFilterQuery(FALSE, "edit") ?>";
fticket_supportedit.Lists["x_status_progress"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fticket_supportedit.Lists["x_status_progress"].Options = <?php echo json_encode($ticket_support_edit->status_progress->Options()) ?>;
fticket_supportedit.Lists["x_na"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fticket_supportedit.Lists["x_na"].Options = <?php echo json_encode($ticket_support_edit->na->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $ticket_support_edit->ShowPageHeader(); ?>
<?php
$ticket_support_edit->ShowMessage();
?>
<form name="fticket_supportedit" id="fticket_supportedit" class="<?php echo $ticket_support_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ticket_support_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ticket_support_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ticket_support">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($ticket_support_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($ticket_support->id_karyawan->Visible) { // id_karyawan ?>
	<div id="r_id_karyawan" class="form-group">
		<label id="elh_ticket_support_id_karyawan" for="x_id_karyawan" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->id_karyawan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->id_karyawan->CellAttributes() ?>>
<span id="el_ticket_support_id_karyawan">
<select data-table="ticket_support" data-field="x_id_karyawan" data-value-separator="<?php echo $ticket_support->id_karyawan->DisplayValueSeparatorAttribute() ?>" id="x_id_karyawan" name="x_id_karyawan"<?php echo $ticket_support->id_karyawan->EditAttributes() ?>>
<?php echo $ticket_support->id_karyawan->SelectOptionListHtml("x_id_karyawan") ?>
</select>
</span>
<?php echo $ticket_support->id_karyawan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->judul->Visible) { // judul ?>
	<div id="r_judul" class="form-group">
		<label id="elh_ticket_support_judul" for="x_judul" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->judul->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->judul->CellAttributes() ?>>
<span id="el_ticket_support_judul">
<input type="text" data-table="ticket_support" data-field="x_judul" name="x_judul" id="x_judul" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($ticket_support->judul->getPlaceHolder()) ?>" value="<?php echo $ticket_support->judul->EditValue ?>"<?php echo $ticket_support->judul->EditAttributes() ?>>
</span>
<?php echo $ticket_support->judul->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->kendala->Visible) { // kendala ?>
	<div id="r_kendala" class="form-group">
		<label id="elh_ticket_support_kendala" for="x_kendala" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->kendala->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->kendala->CellAttributes() ?>>
<span id="el_ticket_support_kendala">
<textarea data-table="ticket_support" data-field="x_kendala" name="x_kendala" id="x_kendala" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ticket_support->kendala->getPlaceHolder()) ?>"<?php echo $ticket_support->kendala->EditAttributes() ?>><?php echo $ticket_support->kendala->EditValue ?></textarea>
</span>
<?php echo $ticket_support->kendala->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->date_create_at->Visible) { // date_create_at ?>
	<div id="r_date_create_at" class="form-group">
		<label id="elh_ticket_support_date_create_at" for="x_date_create_at" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->date_create_at->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->date_create_at->CellAttributes() ?>>
<span id="el_ticket_support_date_create_at">
<input type="text" data-table="ticket_support" data-field="x_date_create_at" data-format="1" name="x_date_create_at" id="x_date_create_at" placeholder="<?php echo ew_HtmlEncode($ticket_support->date_create_at->getPlaceHolder()) ?>" value="<?php echo $ticket_support->date_create_at->EditValue ?>"<?php echo $ticket_support->date_create_at->EditAttributes() ?>>
<?php if (!$ticket_support->date_create_at->ReadOnly && !$ticket_support->date_create_at->Disabled && !isset($ticket_support->date_create_at->EditAttrs["readonly"]) && !isset($ticket_support->date_create_at->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fticket_supportedit", "x_date_create_at", {"ignoreReadonly":true,"useCurrent":false,"format":1});
</script>
<?php } ?>
</span>
<?php echo $ticket_support->date_create_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->status_progress->Visible) { // status_progress ?>
	<div id="r_status_progress" class="form-group">
		<label id="elh_ticket_support_status_progress" for="x_status_progress" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->status_progress->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->status_progress->CellAttributes() ?>>
<span id="el_ticket_support_status_progress">
<select data-table="ticket_support" data-field="x_status_progress" data-value-separator="<?php echo $ticket_support->status_progress->DisplayValueSeparatorAttribute() ?>" id="x_status_progress" name="x_status_progress"<?php echo $ticket_support->status_progress->EditAttributes() ?>>
<?php echo $ticket_support->status_progress->SelectOptionListHtml("x_status_progress") ?>
</select>
</span>
<?php echo $ticket_support->status_progress->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_ticket_support_keterangan" for="x_keterangan" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->keterangan->CellAttributes() ?>>
<span id="el_ticket_support_keterangan">
<textarea data-table="ticket_support" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ticket_support->keterangan->getPlaceHolder()) ?>"<?php echo $ticket_support->keterangan->EditAttributes() ?>><?php echo $ticket_support->keterangan->EditValue ?></textarea>
</span>
<?php echo $ticket_support->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ticket_support->na->Visible) { // na ?>
	<div id="r_na" class="form-group">
		<label id="elh_ticket_support_na" for="x_na" class="<?php echo $ticket_support_edit->LeftColumnClass ?>"><?php echo $ticket_support->na->FldCaption() ?></label>
		<div class="<?php echo $ticket_support_edit->RightColumnClass ?>"><div<?php echo $ticket_support->na->CellAttributes() ?>>
<span id="el_ticket_support_na">
<select data-table="ticket_support" data-field="x_na" data-value-separator="<?php echo $ticket_support->na->DisplayValueSeparatorAttribute() ?>" id="x_na" name="x_na"<?php echo $ticket_support->na->EditAttributes() ?>>
<?php echo $ticket_support->na->SelectOptionListHtml("x_na") ?>
</select>
</span>
<?php echo $ticket_support->na->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="ticket_support" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($ticket_support->id->CurrentValue) ?>">
<?php if (!$ticket_support_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $ticket_support_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ticket_support_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fticket_supportedit.Init();
</script>
<?php
$ticket_support_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ticket_support_edit->Page_Terminate();
?>
