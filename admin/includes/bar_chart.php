                    <div class="row">
                        <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawStuff);

                          function drawStuff() {
                            var data = new google.visualization.arrayToDataTable([
                              ['Data', 'Count'],
                                <?php
                                $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Unapprove Comments', 'Users', 'Subscribers', 'Categories'];
                                $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $unappraoved_comment_count, $user_count, $subscriber_sount, $category_count];
                                for($i = 0; $i < 8; $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }
                                ?>
                            ]);

                            var options = {
                              title: '',
                              width: 'auto',
                              legend: { position: 'none' },
                              chart: { subtitle: '' },
                              axes: {
                                x: {
                                  0: { side: 'top', label: ''} // Top x-axis.
                                }
                              },
                              bar: { groupWidth: "90%" }
                            };

                            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
                            // Convert the Classic options to Material options.
                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          };
                        </script>
                        <div id="top_x_div" style="width: 'auto'; height: 500px;"></div>
                    </div> 