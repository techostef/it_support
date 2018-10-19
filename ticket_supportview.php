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

$ticket_support_view = NULL; // Initialize page object first

class cticket_support_view extends cticket_support {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}';

	// Table name
	var $TableName = 'ticket_support';

	// Page object name
	var $PageObjName = 'ticket_support_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (karyawan)
		if (!isset($GLOBALS['karyawan'])) $GLOBALS['karyawan'] = new ckaryawan();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_karyawan->SetVisibility();
		$this->judul->SetVisibility();
		$this->kendala->SetVisibility();
		$this->date_create_at->SetVisibility();
		$this->status_progress->SetVisibility();
		$this->id_karyawan_pemroses->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->date_diproses->SetVisibility();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "ticket_supportlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "ticket_supportlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "ticket_supportlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ticket_supportlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($ticket_support_view)) $ticket_support_view = new cticket_support_view();

// Page init
$ticket_support_view->Page_Init();

// Page main
$ticket_support_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ticket_support_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fticket_supportview = new ew_Form("fticket_supportview", "view");

// Form_CustomValidate event
fticket_supportview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fticket_supportview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fticket_supportview.Lists["x_id_karyawan"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"karyawan"};
fticket_supportview.Lists["x_id_karyawan"].Data = "<?php echo $ticket_support_view->id_karyawan->LookupFilterQuery(FALSE, "view") ?>";
fticket_supportview.Lists["x_status_progress"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fticket_supportview.Lists["x_status_progress"].Options = <?php echo json_encode($ticket_support_view->status_progress->Options()) ?>;
fticket_supportview.Lists["x_id_karyawan_pemroses"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"karyawan"};
fticket_supportview.Lists["x_id_karyawan_pemroses"].Data = "<?php echo $ticket_support_view->id_karyawan_pemroses->LookupFilterQuery(FALSE, "view") ?>";
fticket_supportview.Lists["x_na"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fticket_supportview.Lists["x_na"].Options = <?php echo json_encode($ticket_support_view->na->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $ticket_support_view->ExportOptions->Render("body") ?>
<?php
	foreach ($ticket_support_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $ticket_support_view->ShowPageHeader(); ?>
<?php
$ticket_support_view->ShowMessage();
?>
<form name="fticket_supportview" id="fticket_supportview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ticket_support_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ticket_support_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ticket_support">
<input type="hidden" name="modal" value="<?php echo intval($ticket_support_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($ticket_support->id_karyawan->Visible) { // id_karyawan ?>
	<tr id="r_id_karyawan">
		<td class="col-sm-2"><span id="elh_ticket_support_id_karyawan"><?php echo $ticket_support->id_karyawan->FldCaption() ?></span></td>
		<td data-name="id_karyawan"<?php echo $ticket_support->id_karyawan->CellAttributes() ?>>
<span id="el_ticket_support_id_karyawan">
<span<?php echo $ticket_support->id_karyawan->ViewAttributes() ?>>
<?php echo $ticket_support->id_karyawan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->judul->Visible) { // judul ?>
	<tr id="r_judul">
		<td class="col-sm-2"><span id="elh_ticket_support_judul"><?php echo $ticket_support->judul->FldCaption() ?></span></td>
		<td data-name="judul"<?php echo $ticket_support->judul->CellAttributes() ?>>
<span id="el_ticket_support_judul">
<span<?php echo $ticket_support->judul->ViewAttributes() ?>>
<?php echo $ticket_support->judul->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->kendala->Visible) { // kendala ?>
	<tr id="r_kendala">
		<td class="col-sm-2"><span id="elh_ticket_support_kendala"><?php echo $ticket_support->kendala->FldCaption() ?></span></td>
		<td data-name="kendala"<?php echo $ticket_support->kendala->CellAttributes() ?>>
<span id="el_ticket_support_kendala">
<span<?php echo $ticket_support->kendala->ViewAttributes() ?>>
<?php echo $ticket_support->kendala->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->date_create_at->Visible) { // date_create_at ?>
	<tr id="r_date_create_at">
		<td class="col-sm-2"><span id="elh_ticket_support_date_create_at"><?php echo $ticket_support->date_create_at->FldCaption() ?></span></td>
		<td data-name="date_create_at"<?php echo $ticket_support->date_create_at->CellAttributes() ?>>
<span id="el_ticket_support_date_create_at">
<span<?php echo $ticket_support->date_create_at->ViewAttributes() ?>>
<?php echo $ticket_support->date_create_at->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->status_progress->Visible) { // status_progress ?>
	<tr id="r_status_progress">
		<td class="col-sm-2"><span id="elh_ticket_support_status_progress"><?php echo $ticket_support->status_progress->FldCaption() ?></span></td>
		<td data-name="status_progress"<?php echo $ticket_support->status_progress->CellAttributes() ?>>
<span id="el_ticket_support_status_progress">
<span<?php echo $ticket_support->status_progress->ViewAttributes() ?>>
<?php echo $ticket_support->status_progress->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->id_karyawan_pemroses->Visible) { // id_karyawan_pemroses ?>
	<tr id="r_id_karyawan_pemroses">
		<td class="col-sm-2"><span id="elh_ticket_support_id_karyawan_pemroses"><?php echo $ticket_support->id_karyawan_pemroses->FldCaption() ?></span></td>
		<td data-name="id_karyawan_pemroses"<?php echo $ticket_support->id_karyawan_pemroses->CellAttributes() ?>>
<span id="el_ticket_support_id_karyawan_pemroses">
<span<?php echo $ticket_support->id_karyawan_pemroses->ViewAttributes() ?>>
<?php echo $ticket_support->id_karyawan_pemroses->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->keterangan->Visible) { // keterangan ?>
	<tr id="r_keterangan">
		<td class="col-sm-2"><span id="elh_ticket_support_keterangan"><?php echo $ticket_support->keterangan->FldCaption() ?></span></td>
		<td data-name="keterangan"<?php echo $ticket_support->keterangan->CellAttributes() ?>>
<span id="el_ticket_support_keterangan">
<span<?php echo $ticket_support->keterangan->ViewAttributes() ?>>
<?php echo $ticket_support->keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->date_diproses->Visible) { // date_diproses ?>
	<tr id="r_date_diproses">
		<td class="col-sm-2"><span id="elh_ticket_support_date_diproses"><?php echo $ticket_support->date_diproses->FldCaption() ?></span></td>
		<td data-name="date_diproses"<?php echo $ticket_support->date_diproses->CellAttributes() ?>>
<span id="el_ticket_support_date_diproses">
<span<?php echo $ticket_support->date_diproses->ViewAttributes() ?>>
<?php echo $ticket_support->date_diproses->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ticket_support->na->Visible) { // na ?>
	<tr id="r_na">
		<td class="col-sm-2"><span id="elh_ticket_support_na"><?php echo $ticket_support->na->FldCaption() ?></span></td>
		<td data-name="na"<?php echo $ticket_support->na->CellAttributes() ?>>
<span id="el_ticket_support_na">
<span<?php echo $ticket_support->na->ViewAttributes() ?>>
<?php echo $ticket_support->na->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fticket_supportview.Init();
</script>
<?php
$ticket_support_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ticket_support_view->Page_Terminate();
?>
