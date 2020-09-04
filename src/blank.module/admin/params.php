<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix//modules/main/prolog.php");

CJSCore::Init(array("jquery"));

$APPLICATION->SetTitle("Дополнительные настройки");

require_once($_SERVER['DOCUMENT_ROOT'] .'/bitrix/modules/main/include/prolog_admin_after.php');
IncludeModuleLangFile("/home/bitrix/www/bitrix/modules/main/admin/user_admin.php");



CModule::IncludeModule('lingua.params');

if(isset($_GET["activate_enroll"]) && !empty($_GET["activate_enroll"])) {

	if($_GET["activate_enroll"] == "on") {
		COption::SetOptionString("your.module", "PARAM_1_NAME", "Y");
	} else {
		COption::SetOptionString("your.module", "PARAM_1_NAME", "N");
	}
}
?>
	<div class="">
		<div class="adm-detail-content-item-block">
			<div>
				<div class="adm-detail-content-btns upload-status">
				<?php
					$enrollActivity = COption::GetOptionString("lingua.params", "PARAM_1_NAME");
					?>
					<form action="">
						<label for="activate_enroll">
							Включить набор
							<input type="hidden" name="activate_enroll" value="off" />
							<input id="activate_enroll" name="activate_enroll" type="checkbox" <? echo ($enrollActivity == (string)"Y") ? "checked" : ""?>>
						</label>
						<button>Сохранить</button>
					</form>
				</div>
				
			</div>
		</div>
	</div>
<script>
	$( document ).ready(function() {
	

	});
</script>
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_admin.php");
?>

