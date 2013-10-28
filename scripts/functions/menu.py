import pygame


class Menu (object) :
	def __init__ (self, screen, font) :

		self.screen = screen
		self.background_menu = pygame.Surface(screen.get_size())
		self.background_menu = self.background_menu.convert()
		self.background_menu.fill((0, 0, 0))

		text_menu_time = font.render("Modifier l'heure", 1, (255, 255, 255))
		text_menu_time_pos = text_menu_time.get_rect(x=20, y=20)
		self.background_menu.blit(text_menu_time, text_menu_time_pos)

		text_menu_snooze = font.render("Modifier l'action du snooze", 1, (255, 255, 255))
		text_menu_snooze_pos = text_menu_snooze.get_rect(x=20, y=40)
		self.background_menu.blit(text_menu_snooze, text_menu_snooze_pos)

	

	def show(self) :
		for i in range(240, -1) :
			self.screen.blit(self.background_menu, (0, i))
			pygame.display.flip()
			time.sleep(0.0005)

	def hide(self) :
		for i in range(240) :
			self.screen.blit(self.background_menu, (0, i))
			pygame.display.flip()
			time.sleep(0.0005)
