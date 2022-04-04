# semafor

semafor is a network status monitor written in PHP.

## Description

The web frontend shows the status of a series of hosts. It allows testing separately ICMP echo and specific ports.

## Configuration

`config.php` holds the general configuration options. `hosts.php` is self explanatory:

```
$hosts = [
	['name' => 'example.com', 'port' => 80, 'description' => 'random web server'],
	['name' => 'serveis.guifi.net', 'port' => 53, 'description' => 'DNS forwarder'],
	['name' => '1.0.0.1', 'port' => 53, 'description' => 'yet another nameserver'],
	['name' => '10.12.0.101', 'port' => 3389, 'description' => 'a local machine'],
];
```

The software can be easily localised with language files under *locale/*.

## Screenshots

![semafor](/screenshots/semafor.png?raw=true "semafor")

## License

This project is licensed under the GNU General Public License - see the LICENSE file for details.
