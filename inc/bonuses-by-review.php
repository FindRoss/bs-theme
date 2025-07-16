<?php

/*
* GET BONUSES FOR REVIEW OR BASED ON REVIEW ID
*
*/

function get_bonuses_by_review_query($id) {
  if (!$id) return;

  $query = new WP_Query(
    array (
      'post_type'      => 'bonus',
      'posts_per_page' => 12,
      'meta_query'     => array(
        'relation' => 'AND', 
        array(
          'key'     => 'single_bonus_casino', 
          'value'   => '"' . $id . '"',
          'compare' => 'LIKE'
        ),
        array(
          'key'     => 'bonus_expired',
          'value'   => '1',
          'compare' => '!='
        )
      )
    )
  );

  return $query;
};


//  $query = new WP_Query(
//     array (
//       'post_type'      => 'bonus',
//       'posts_per_page' => 12,
//       'meta_query'     => array(
//         'relation' => 'AND', 
//         array(
//           'key'     => 'single_bonus_casino', 
//           'value'   => '"' . $id . '"',
//           'compare' => 'LIKE'
//         ),
//         array(
//           'relation' => 'AND',
//           array(
//             'key'     => 'bonus_expired',
//             'value'   => '1',
//             'compare' => '!='
//           ),
//           array(
//             'relation' => 'OR', 
//             array(
//                 'key'     => 'expiry_date', 
//                 'value'   => date('Ymd'),
//                 'compare' => '>',
//                 'type'    => 'DATE'
//             ),
//             array(
//                 'key'     => 'expiry_date',
//                 'value'   => '',   // Empty value for no expiry date
//                 'compare' => '='
//             ),
//           ),
//         )
//       )
//     )
//   );

  