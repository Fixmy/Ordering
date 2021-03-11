<?php

return [
	'database_predecessor' => 'fixme_',
	'merchant_delivery_field' => 'provides_delivery',
	'polymorph_bindings' => [
		'product' => 'App\Models\Items\Item',
		'beneficiary' => 'App\Models\Users\Beneficiary',
	],
];

?>