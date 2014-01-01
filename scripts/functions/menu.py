import pygame
import time
import copy

class Menu (object) :
	def __init__ (self, screen, items, font, front_color, back_color) :
		self.screen = screen
		self.background_menu = pygame.Surface(screen.get_size())
		self.background_menu = self.background_menu.convert()
		self.background_menu.fill(back_color)
		self.front_color = front_color
		self.back_color = back_color
		self.current_selected = -1
		self.font = font
		self.items = items

		for i in range(len(self.items)) :
			text = (pygame.font.Font(None, 17)).render(self.items[i], 1, self.front_color)
			text_pos = text.get_rect(x=20, y=20*(i+1))
			self.background_menu.blit(text, text_pos)
	

	def show(self) :
		for i in range(240, 0, -1) :
			self.screen.blit(self.background_menu, (0, i))
			pygame.display.update()
			time.sleep(0.0005)

	def hide(self) :
		for i in range(240) :
			self.screen.blit(self.background_menu, (0, i))
			pygame.display.update()
			time.sleep(0.0005)
		self.current_selected = -1

	def select(self, index) :
		self.background_menu.fill(self.back_color)
		for i in range(len(self.items)) :
			font = pygame.font.Font(self.font, 17)
			font_bold = pygame.font.Font(self.font, 17)
			font_bold.set_underline(True)
			if index == i :
				text = font_bold.render(self.items[i].decode("utf-8"), 1, self.front_color)
			else : 
				text = font.render(self.items[i].decode("utf-8"), 1, self.front_color)
			
			text_pos = text.get_rect(x=20, y=20*(i+1))
			self.background_menu.blit(text, text_pos)
		self.screen.blit(self.background_menu, (0, i))
		pygame.display.flip()

	def select_delta(self, delta) :
		if self.current_selected != -1 :
			index = (self.current_selected + delta)%(len(self.items))
		else : 
			index = 0
		self.select(index)
		self.current_selected = index

