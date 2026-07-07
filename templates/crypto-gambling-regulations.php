<?php
/*
Template Name: Crypto Gambling Regulations Tracker
Template Post Type: page, post
*/

get_header();

$region_order = [ 'North America', 'South America', 'Europe', 'Asia-Pacific', 'Middle East & Africa' ];

$status_labels = [
	'banned' => 'Completely Banned',
	'grey'   => 'Grey Market',
	'legal'  => 'Legal & Regulated',
];

$jurisdictions = [];

if ( have_rows( 'jurisdictions' ) ) {
	while ( have_rows( 'jurisdictions' ) ) {
		the_row();
		$jurisdictions[] = [
			'country_name' => get_sub_field( 'country_name' ),
			'region'       => get_sub_field( 'region' ),
			'status_key'   => get_sub_field( 'status_key' ),
			'status_label' => get_sub_field( 'status_label' ),
			'detail'       => get_sub_field( 'detail' ),
		];
	}
}

// Dummy data fallback so the page is testable before ACF content is entered.
if ( empty( $jurisdictions ) ) {
	$jurisdictions = [
		[ 'country_name' => 'United States', 'region' => 'North America', 'status_key' => 'grey', 'status_label' => 'Unregulated (Fragmented)', 'detail' => 'Federal law does not criminalize individual players, but enforcement is pushed onto operators and payment processors. States diverge sharply on enforcement posture.' ],
		[ 'country_name' => 'Canada', 'region' => 'North America', 'status_key' => 'grey', 'status_label' => 'Unregulated (Provincial)', 'detail' => 'Gambling is delegated to the provinces. Ontario runs a regulated private-operator market, while other provinces rely on offshore sites.' ],
		[ 'country_name' => 'Brazil', 'region' => 'South America', 'status_key' => 'banned', 'status_label' => 'Completely Banned', 'detail' => 'Brazil\'s fixed-odds framework admits only authorized fiat operators. Crypto-denominated gambling falls outside the licensing regime.' ],
		[ 'country_name' => 'Argentina', 'region' => 'South America', 'status_key' => 'banned', 'status_label' => 'Completely Banned', 'detail' => 'Gambling is regulated province-by-province, and most provinces prohibit crypto payment rails outright.' ],
		[ 'country_name' => 'United Kingdom', 'region' => 'Europe', 'status_key' => 'legal', 'status_label' => 'Legal (Strict Compliance)', 'detail' => 'The Gambling Commission and the FCA jointly govern crypto wagering. Licensed platforms must enforce full KYC and AML checks.' ],
		[ 'country_name' => 'Germany', 'region' => 'Europe', 'status_key' => 'banned', 'status_label' => 'Completely Banned', 'detail' => 'Licensed play is highly restricted with deposit caps and stake limits, but excludes crypto entirely.' ],
		[ 'country_name' => 'Estonia', 'region' => 'Europe', 'status_key' => 'legal', 'status_label' => 'Legal (Regulated / Taxed)', 'detail' => 'Estonia offers a legal route for crypto-friendly play through its Tax and Customs Board, with a remote-gaming tax applying.' ],
		[ 'country_name' => 'Australia', 'region' => 'Asia-Pacific', 'status_key' => 'banned', 'status_label' => 'Completely Banned', 'detail' => 'The Interactive Gambling Act prohibits online crypto casino play, with regulators ordering blocks on offshore platforms.' ],
		[ 'country_name' => 'India', 'region' => 'Asia-Pacific', 'status_key' => 'grey', 'status_label' => 'Unregulated / Grey Market', 'detail' => 'Gambling is regulated at the state level, producing an inconsistent patchwork where crypto play is unregulated in many states.' ],
		[ 'country_name' => 'South Africa', 'region' => 'Middle East & Africa', 'status_key' => 'banned', 'status_label' => 'Completely Banned', 'detail' => 'The National Gambling Act prohibits online casino play, and crypto wagering falls under the same ban.' ],
		[ 'country_name' => 'Nigeria', 'region' => 'Middle East & Africa', 'status_key' => 'grey', 'status_label' => 'Unregulated / Grey Market', 'detail' => 'A shake-up between federal and state gambling authorities has left crypto play in an unregulated limbo.' ],
	];
}

$total_count = count( $jurisdictions );

$status_counts = [ 'banned' => 0, 'grey' => 0, 'legal' => 0 ];
foreach ( $jurisdictions as $j ) {
	if ( isset( $status_counts[ $j['status_key'] ] ) ) {
		$status_counts[ $j['status_key'] ]++;
	}
}
?>

<div id="crypto-regs-tracker" class="crypto-regs container">

	<!-- Masthead -->
	<div class="crypto-regs__masthead">
		<div class="crypto-regs__kicker">
			<span class="crypto-regs__kicker-dot"></span>
			Global Regulatory Tracker · Updated <?php echo esc_html( date( 'Y' ) ); ?>
		</div>
		<h1 class="crypto-regs__title"><?php the_title(); ?></h1>
		<div class="crypto-regs__deck"><?php the_content(); ?></div>
		<div class="crypto-regs__byline">
			<span><?php echo esc_html( $total_count ); ?> jurisdictions tracked</span>
			<span class="crypto-regs__byline-dot"></span>
			<span>Educational reference only</span>
		</div>
	</div>

	<!-- Stats strip -->
	<div class="crypto-regs__stats">
		<div class="crypto-regs__stat">
			<div class="crypto-regs__stat-num"><?php echo esc_html( $total_count ); ?></div>
			<div class="crypto-regs__stat-label">Jurisdictions</div>
		</div>
		<div class="crypto-regs__stat">
			<div class="crypto-regs__stat-num crypto-regs__stat-num--banned"><?php echo esc_html( $status_counts['banned'] ); ?></div>
			<div class="crypto-regs__stat-label">Completely banned</div>
		</div>
		<div class="crypto-regs__stat">
			<div class="crypto-regs__stat-num crypto-regs__stat-num--grey"><?php echo esc_html( $status_counts['grey'] ); ?></div>
			<div class="crypto-regs__stat-label">Grey market</div>
		</div>
		<div class="crypto-regs__stat">
			<div class="crypto-regs__stat-num crypto-regs__stat-num--legal"><?php echo esc_html( $status_counts['legal'] ); ?></div>
			<div class="crypto-regs__stat-label">Legal &amp; regulated</div>
		</div>
	</div>

	<div class="row crypto-regs__body">
		<div class="col-12 col-lg-8">

			<!-- Filter bar -->
			<div class="crypto-regs__filterbar" id="crypto-regs-filterbar">
				<div class="crypto-regs__filterrow">
					<div class="crypto-regs__search">
						<?php echo get_svg_icon( 'search' ); ?>
						<input type="text" id="crypto-regs-search" class="crypto-regs__search-input" placeholder="Search a country…" autocomplete="off" />
					</div>
					<div class="crypto-regs__chips" data-chip-group="status">
						<button type="button" class="crypto-regs__chip is-active" data-status="all">All <span class="crypto-regs__chip-count"><?php echo esc_html( $total_count ); ?></span></button>
						<button type="button" class="crypto-regs__chip" data-status="banned">Banned <span class="crypto-regs__chip-count"><?php echo esc_html( $status_counts['banned'] ); ?></span></button>
						<button type="button" class="crypto-regs__chip" data-status="grey">Grey <span class="crypto-regs__chip-count"><?php echo esc_html( $status_counts['grey'] ); ?></span></button>
						<button type="button" class="crypto-regs__chip" data-status="legal">Legal <span class="crypto-regs__chip-count"><?php echo esc_html( $status_counts['legal'] ); ?></span></button>
					</div>
				</div>
				<div class="crypto-regs__filterrow crypto-regs__filterrow--region">
					<span class="crypto-regs__filterlabel">Region</span>
					<div class="crypto-regs__chips" data-chip-group="region">
						<button type="button" class="crypto-regs__chip is-active" data-region="all">All regions</button>
						<?php foreach ( $region_order as $region ) : ?>
							<button type="button" class="crypto-regs__chip" data-region="<?php echo esc_attr( $region ); ?>"><?php echo esc_html( $region ); ?></button>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<!-- Result meta -->
			<div class="crypto-regs__resultmeta">
				<div class="crypto-regs__resultcount">Showing <span id="crypto-regs-count"><?php echo esc_html( $total_count ); ?></span> of <?php echo esc_html( $total_count ); ?></div>
				<button type="button" class="crypto-regs__resetlink" data-reset>Reset filters</button>
			</div>

			<!-- Grouped list -->
			<div id="crypto-regs-groups">
				<?php foreach ( $region_order as $region ) :
					$rows = array_values( array_filter( $jurisdictions, function ( $j ) use ( $region ) {
						return $j['region'] === $region;
					} ) );

					if ( empty( $rows ) ) {
						continue;
					}
					?>
					<div class="crypto-regs__group" data-region="<?php echo esc_attr( $region ); ?>">
						<div class="crypto-regs__group-head">
							<span class="crypto-regs__group-title"><?php echo esc_html( $region ); ?></span>
							<span class="crypto-regs__group-count" data-group-count><?php echo esc_html( count( $rows ) ); ?></span>
						</div>
						<div class="crypto-regs__group-body">
							<?php foreach ( $rows as $row ) :
								$status_key = $row['status_key'] ? $row['status_key'] : 'grey';
								$status_label = $row['status_label'] ? $row['status_label'] : ( isset( $status_labels[ $status_key ] ) ? $status_labels[ $status_key ] : '' );
								?>
								<div class="crypto-regs__row" data-name="<?php echo esc_attr( strtolower( $row['country_name'] ) ); ?>" data-region="<?php echo esc_attr( $region ); ?>" data-status="<?php echo esc_attr( $status_key ); ?>">
									<div class="crypto-regs__row-head" data-row-toggle>
										<div class="crypto-regs__row-name">
											<span class="crypto-regs__dot crypto-regs__dot--<?php echo esc_attr( $status_key ); ?>"></span>
											<span><?php echo esc_html( $row['country_name'] ); ?></span>
										</div>
										<div>
											<span class="info-pill info-pill--<?php echo esc_attr( $status_key ); ?>"><?php echo esc_html( $status_label ); ?></span>
										</div>
										<div class="crypto-regs__chevron"><?php echo get_svg_icon( 'chevron-right' ); ?></div>
									</div>
									<div class="crypto-regs__row-detail">
										<div class="crypto-regs__row-detail-text"><?php echo wp_kses_post( $row['detail'] ); ?></div>
										<div class="crypto-regs__row-metaline">
											<span><span class="crypto-regs__metalabel">Region</span> <?php echo esc_html( $region ); ?></span>
											<span><span class="crypto-regs__metalabel">Status</span> <?php echo esc_html( $status_label ); ?></span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Empty state -->
			<div id="crypto-regs-empty" class="crypto-regs__empty" hidden>
				<div class="crypto-regs__empty-title">No jurisdictions match</div>
				<div class="crypto-regs__empty-text">Try a different search term or clear the filters.</div>
				<button type="button" class="crypto-regs__empty-reset" data-reset>Reset filters</button>
			</div>

		</div>

		<!-- Sidebar -->
		<div class="col-12 col-lg-4">
			<aside class="sidebar">
				<div class="sidebar__widget crypto-regs__classify">
					<h3 class="sidebar__widget--title">How we classify</h3>
					<div class="crypto-regs__legend">
						<div class="crypto-regs__legend-row">
							<span class="crypto-regs__dot crypto-regs__dot--banned"></span>
							<span><strong>Completely banned</strong> — crypto wagering is prohibited and actively blocked.</span>
						</div>
						<div class="crypto-regs__legend-row">
							<span class="crypto-regs__dot crypto-regs__dot--grey"></span>
							<span><strong>Grey market</strong> — no clear law; enforcement is inconsistent.</span>
						</div>
						<div class="crypto-regs__legend-row">
							<span class="crypto-regs__dot crypto-regs__dot--legal"></span>
							<span><strong>Legal &amp; regulated</strong> — permitted under a licensing regime.</span>
						</div>
					</div>
					<div class="crypto-regs__disclaimer">Laws change frequently. This page is an educational reference, not legal advice — verify your local rules before acting.</div>
				</div>
			</aside>
		</div>

	</div>
</div>

<?php get_footer(); ?>
