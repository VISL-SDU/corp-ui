# Indexing corpora

Once a corpus has been Manatee'd, add it to the interface and index it with these steps:

* If there are interesting subcorpora, run e.g. `mksubc ~/registry/dan_twitter ~/corpora/dan_twitter/subc/ ~/registry/dan_twitter.subc`
```
mkdir -pv ~/corpora/dan_twitter/meta  ~/corpora/dan_twitter/tmp
cd ~/corpora/dan_twitter/tmp

# Count tokens, absolute frequencies, and histograms. Use -total if there are no lstamp with years
~/public_html/_bin/decodevert-word-lex ~/registry/dan_twitter | time ~/public_html/_src/build/index-corpus-year-lstamp
cat commands.sql | time sqlite3 stats.sqlite

# Calculate relative frequencies
time ~/public_html/_bin/stats-calc ~/corpora/dan_twitter/tmp/stats.sqlite

mv -v ~/corpora/dan_twitter/tmp/stats.sqlite ~/corpora/dan_twitter/meta/stats.sqlite
rm -rf ~/corpora/dan_twitter/tmp
```
* Edit `_inc/config.php` to add it and all subcorpora to the `$GLOBALS['-corpora']` array.
* Update global stats for the language with `time ~/public_html/_bin/stats-combine dan`

## TODO
* Scale corpora relfreqs to 10 million words so cross-corpus comparisons are possible
* Histogram:
  * Warn about missing data and inject those groups as grey
  * Warn about sparse data and color those yellow
  * Show combined timeline if subcorpora
  * Show multiple corpora under top
  * Click on bar to jump to that place in the table
  * Click on table line to show all hits from that period
  * Menu to pick which field to graph
* Maybe split off more dynamic fields
