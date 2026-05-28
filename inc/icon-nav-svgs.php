<?php
function bs_get_icon_nav_svg( string $key ): string {
	$icons = array(

		'icon-crypto' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<circle cx="16" cy="16" r="11"/>
			<circle cx="16" cy="16" r="7.5" stroke-dasharray="1.5 2.5"/>
			<path d="M14 11.5v9"/>
			<path d="M13 13.5h4.2a1.8 1.8 0 0 1 0 3.5H13"/>
			<path d="M13 17h4.7a1.8 1.8 0 0 1 0 3.5H13"/>
			<path d="M15.5 10.2v1.3M15.5 20.5v1.3M17 10.2v1.3M17 20.5v1.3"/>
		</svg>',

		'icon-sweeps' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M5 12a2 2 0 0 1 2-2h18a2 2 0 0 1 2 2v1.5a2 2 0 0 0 0 4V19a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-1.5a2 2 0 0 0 0-4V12Z"/>
			<path d="M13 11v10" stroke-dasharray="1.5 2"/>
			<path d="M17 14.5h6"/>
			<path d="M17 17.5h4"/>
		</svg>',

		'icon-poker' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M16 6c-2.5 3.2-7 6-7 10.2A4.3 4.3 0 0 0 13.3 20.5c1 0 1.9-.4 2.7-1"/>
			<path d="M16 6c2.5 3.2 7 6 7 10.2A4.3 4.3 0 0 1 18.7 20.5c-1 0-1.9-.4-2.7-1"/>
			<path d="M14 25c.6-1.5 1.2-3 2-5"/>
			<path d="M18 25c-.6-1.5-1.2-3-2-5"/>
		</svg>',

		'icon-sports' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M6 16c0-5 4.5-9.5 10-9.5S26 11 26 16s-4.5 9.5-10 9.5S6 21 6 16Z"/>
			<path d="M11 16h10"/>
			<path d="M13 14v4M15.5 14v4M18 14v4"/>
			<path d="M9 11.5c-.5 1.4-.8 2.9-.8 4.5s.3 3.1.8 4.5"/>
			<path d="M23 11.5c.5 1.4.8 2.9.8 4.5s-.3 3.1-.8 4.5"/>
		</svg>',

		'icon-cashback' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<circle cx="13" cy="17" r="6.5"/>
			<path d="M13 13.5v7"/>
			<path d="M11 15.5h2.5a1.4 1.4 0 0 1 0 2.8H11"/>
			<path d="M11 18.3h3a1.4 1.4 0 0 1 0 2.7H11"/>
			<path d="M19 6.5a8 8 0 0 1 5.5 11"/>
			<path d="M24.5 12v5.5h-5.5"/>
		</svg>',

		'icon-wagerfree' => '<svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M6.5 12.5h19V15a1 1 0 0 1-1 1H7.5a1 1 0 0 1-1-1v-2.5Z"/>
			<path d="M8 16v8.5a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V16"/>
			<path d="M16 12.5v13"/>
			<path d="M16 12.5c-2-3-6-3-6-.8 0 .8.7 1.3 1.4 1.3H16"/>
			<path d="M16 12.5c2-3 6-3 6-.8 0 .8-.7 1.3-1.4 1.3H16"/>
			<path d="M19.5 20l1.8 1.8 3.2-3.6"/>
		</svg>',

	);

	return $icons[ $key ] ?? '';
}
