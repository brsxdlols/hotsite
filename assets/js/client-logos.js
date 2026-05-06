window.CLIENT_LOGOS = [
  { file: 'Logo-AMNET.jpg', name: 'AMNET' },
  { file: 'Logo-Cajanet.png', name: 'Cajanet' },
  { file: 'Logo-Camynet.png', name: 'Camynet' },
  { file: 'Logo-Clinicpnet.jpg', name: 'Clinicpnet' },
  { file: 'Logo-Compact-Telecom.jpg', name: 'Compact Telecom' },
  { file: 'Logo-Conexlink.jpg', name: 'Conexlink' },
  { file: 'Logo-Connect-Fibra.jpg', name: 'Connect Fibra' },
  { file: 'Logo-Domnet.jpg', name: 'Domnet' },
  { file: 'Logo-FCSNET.png', name: 'FCSNET' },
  { file: 'Logo-FiberAta.jpg', name: 'FiberAta' },
  { file: 'Logo-Flynet.jpg', name: 'Flynet' },
  { file: 'Logo-GDFIBRA.jpg', name: 'GDFIBRA' },
  { file: 'Logo-HZTelecom.jpg', name: 'HZ Telecom' },
  { file: 'Logo-JBNET.jpg', name: 'JBNET' },
  { file: 'Logo-KMNET.jpg', name: 'KMNET' },
  { file: 'Logo-Libratelecom.png', name: 'Libra Telecom' },
  { file: 'Logo-Linhanet.jpg', name: 'Linhanet' },
  { file: 'Logo-Meganet.jpg', name: 'Meganet' },
  { file: 'Logo-Multifibra.jpg', name: 'Multifibra' },
  { file: 'Logo-Netmania.jpg', name: 'Netmania' },
  { file: 'Logo-Onlinetelecom.jpg', name: 'Online Telecom' },
  { file: 'Logo-Quality.png', name: 'Quality' },
  { file: 'Logo-Ruralnet.jpg', name: 'Ruralnet' },
  { file: 'Logo-Seven.jpg', name: 'Seven' },
  { file: 'Logo-Unixnet.jpg', name: 'Unixnet' },
  { file: 'Logo-Visualnet.jpg', name: 'Visualnet' },
  { file: 'Logo-VRInternet.jpg', name: 'VR Internet' },
  { file: 'Logo-Cybertop.jpg', name: 'Cybertop' }
];

window.getClientLogoPath = function getClientLogoPath(fileName) {
  return encodeURI('Logos clientes/' + fileName);
};
