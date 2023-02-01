# semafor

A network status monitor written in PHP.

## Description

The web frontend shows the status of a series of hosts. It allows testing ICMP echo and specific ports simultaneously.

## Configuration

`config.php` holds the general configuration options. `hosts.php` is self explanatory:

```
$hosts = [
  ['name' => 'example.com', 'port' => 80, 'description' => 'random web server'],
  ['name' => 'serveis.guifi.net', 'port' => 53, 'description' => 'a nameserver'],
  ['name' => 'udp://0.be.pool.ntp.org', 'port' => 123, 'description' => 'a time server'],
  ['name' => 'example.com', 'port' => 8080, 'description' => 'filtered port'],
  ['name' => '1.2.3.4', 'port' => 21, 'description' => 'random address'],
];
```

The software can be easily localised with language files under *locale/*.

## Screenshots

![semafor](/screenshots/semafor.png?raw=true "semafor")

## License

This project is licensed under the GNU General Public License - see the LICENSE file for details.
